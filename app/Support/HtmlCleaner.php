<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Keeps the formatting an admin types in the rich editor (bold, colours,
 * lists, headings, RTL...) and throws away everything that could run code.
 * Allow-list based: unknown tags are unwrapped, unknown attributes dropped.
 */
class HtmlCleaner
{
    private const TAGS = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'strike', 'sub', 'sup',
        'h1', 'h2', 'h3', 'h4', 'blockquote', 'ul', 'ol', 'li', 'a', 'span', 'div', 'hr', 'pre', 'code',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'td', 'th', 'caption', 'colgroup', 'col'];
    private const DROP = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'textarea', 'select', 'link', 'meta', 'svg', 'math'];
    private const STYLE_PROPS = ['color', 'background-color', 'text-align', 'direction', 'font-size', 'font-family', 'padding-left', 'padding-right',
        'padding', 'padding-top', 'padding-bottom', 'font-weight', 'font-style', 'text-decoration', 'vertical-align', 'width', 'height',
        'border', 'border-top', 'border-right', 'border-bottom', 'border-left', 'border-collapse', 'border-color', 'border-style', 'border-width'];
    /** Plain numeric/percent attributes worth keeping (tables from Word, Docs). */
    private const NUM_ATTRS = ['colspan', 'rowspan', 'border', 'cellpadding', 'cellspacing', 'width', 'height'];

    public static function clean(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }
        // Plain text typed before the editor existed: keep its line breaks.
        if (!preg_match('/<[a-z][\s\S]*>/i', $html)) {
            $html = '<p>' . nl2br(e($html), false) . '</p>';
        }

        $doc = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?><div id="__root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $root = $doc->getElementById('__root') ?: $doc->documentElement;
        self::walk($root);

        $out = '';
        foreach (iterator_to_array($root->childNodes) as $child) {
            $out .= $doc->saveHTML($child);
        }
        $out = trim($out);
        // The editor's "empty" document
        return in_array($out, ['', '<p><br></p>'], true) ? '' : $out;
    }

    /** Plain-text preview (for lists). */
    public static function excerpt(?string $html, int $len = 160): string
    {
        $t = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags(str_replace(['</p>', '<br>', '</li>'], ' ', (string) $html)), ENT_QUOTES, 'UTF-8')));
        return mb_strlen($t) > $len ? mb_substr($t, 0, $len) . '…' : $t;
    }

    private static function walk(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if (!$child instanceof DOMElement) {
                if ($child->nodeType === XML_COMMENT_NODE) {
                    $node->removeChild($child);
                }
                continue;
            }
            $tag = strtolower($child->tagName);

            if (in_array($tag, self::DROP, true)) {
                $node->removeChild($child);
                continue;
            }

            self::walk($child);

            if (!in_array($tag, self::TAGS, true)) {
                // unwrap: keep the text, lose the tag
                while ($child->firstChild) {
                    $node->insertBefore($child->firstChild, $child);
                }
                $node->removeChild($child);
                continue;
            }

            self::cleanAttributes($child, $tag);
        }
    }

    private static function cleanAttributes(DOMElement $el, string $tag): void
    {
        $style = [];
        $indent = 0;
        $rtl = false;

        // Editor classes -> inline styles the mobile app understands
        $classes = preg_split('/\s+/', (string) $el->getAttribute('class'), -1, PREG_SPLIT_NO_EMPTY);
        foreach ($classes as $c) {
            if (preg_match('/^ql-indent-([1-8])$/', $c, $m)) $indent = (int) $m[1];
            if ($c === 'ql-direction-rtl') { $style['direction'] = 'rtl'; }
            if (preg_match('/^ql-align-(center|right|justify)$/', $c, $m)) { $style['text-align'] = $m[1]; }
        }

        foreach (explode(';', (string) $el->getAttribute('style')) as $decl) {
            if (!str_contains($decl, ':')) continue;
            [$k, $v] = array_map('trim', explode(':', $decl, 2));
            $k = strtolower($k);
            if (!in_array($k, self::STYLE_PROPS, true)) continue;
            if (!preg_match('/^[#a-zA-Z0-9(),.%\s-]+$/', $v) || stripos($v, 'url') !== false || stripos($v, 'expression') !== false) continue;
            $style[$k] = $v;
        }
        $rtl = ($style['direction'] ?? '') === 'rtl';
        if ($indent) {
            $style[$rtl ? 'padding-right' : 'padding-left'] = ($indent * 2) . 'em';
        }

        $href = $tag === 'a' ? trim((string) $el->getAttribute('href')) : '';
        $keep = [];
        if (in_array($tag, ['table', 'td', 'th', 'col', 'colgroup', 'tr'], true)) {
            foreach (self::NUM_ATTRS as $a) {
                $v = trim((string) $el->getAttribute($a));
                if ($v !== '' && preg_match('/^\d{1,4}%?$/', $v)) $keep[$a] = $v;
            }
        }
        foreach (iterator_to_array($el->attributes) as $attr) {
            $el->removeAttribute($attr->name);
        }

        foreach ($keep as $a => $v) {
            $el->setAttribute($a, $v);
        }
        if ($style) {
            $el->setAttribute('style', implode(';', array_map(fn ($k, $v) => "$k:$v", array_keys($style), $style)));
        }
        if ($tag === 'a' && preg_match('#^(https?://|mailto:|tel:)#i', $href)) {
            $el->setAttribute('href', $href);
            $el->setAttribute('target', '_blank');
            $el->setAttribute('rel', 'noopener noreferrer');
        }
    }
}
