<?php

namespace App\Helpers;

use getID3;
use getid3_lib;
use getid3_writetags;

// use getID3 as GlobalGetID3;
// use getid3_writetags;
// use Owenoj\LaravelGetId3\GetId3;

class UpdateMetadata
{
    public function updateMetadata($mp3File, $albumName)
    {

        $TaggingFormat = 'UTF-8';

        header('Content-Type: text/html; charset='.$TaggingFormat);

        // require_once('../getid3/getid3.php');
        // Initialize getID3 engine
        $getID3 = new getID3;
        $getID3->setOption(array('encoding'=>$TaggingFormat));

        // getid3_lib::IncludeDependency(GETID3_INCLUDEPATH.'write.php', __FILE__, true);

        $browsescriptfilename = 'demo.browse.php';

        $Filename = $mp3File;
        // $Filename = (isset($_REQUEST['Filename']) ? $_REQUEST['Filename'] : '');



        // if (isset($_POST['WriteTags'])) {

            $TagFormatsToWrite = (isset($_POST['TagFormatsToWrite']) ? $_POST['TagFormatsToWrite'] : array());
            dd($TagFormatsToWrite);
            if (!empty($TagFormatsToWrite)) {
                echo 'starting to write tag(s)<BR>';

                $tagwriter = new getid3_writetags;
                $tagwriter->filename       = $Filename;
                $tagwriter->tagformats     = $TagFormatsToWrite;
                $tagwriter->overwrite_tags = false;
                $tagwriter->tag_encoding   = $TaggingFormat;
                if (!empty($_POST['remove_other_tags'])) {
                    $tagwriter->remove_other_tags = true;
                }

                $commonkeysarray = array('Title', 'Artist', 'Album', 'Year', 'Comment');
                foreach ($commonkeysarray as $key) {
                    if (!empty($_POST[$key])) {
                        $TagData[strtolower($key)][] = $_POST[$key];
                    }
                }
                if (!empty($_POST['Genre'])) {
                    $TagData['genre'][] = $_POST['Genre'];
                }
                if (!empty($_POST['GenreOther'])) {
                    $TagData['genre'][] = $_POST['GenreOther'];
                }
                if (!empty($_POST['Track'])) {
                    $TagData['track_number'][] = $_POST['Track'].(!empty($_POST['TracksTotal']) ? '/'.$_POST['TracksTotal'] : '');
                }

                if (!empty($_FILES['userfile']['tmp_name'])) {
                    if (in_array('id3v2.4', $tagwriter->tagformats) || in_array('id3v2.3', $tagwriter->tagformats) || in_array('id3v2.2', $tagwriter->tagformats)) {
                        if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                            if ($APICdata = file_get_contents($_FILES['userfile']['tmp_name'])) {

                                if ($exif_imagetype = exif_imagetype($_FILES['userfile']['tmp_name'])) {

                                    $TagData['attached_picture'][0]['data']          = $APICdata;
                                    $TagData['attached_picture'][0]['picturetypeid'] = $_POST['APICpictureType'];
                                    $TagData['attached_picture'][0]['description']   = $_FILES['userfile']['name'];
                                    $TagData['attached_picture'][0]['mime']          = image_type_to_mime_type($exif_imagetype);

                                } else {
                                    echo '<b>invalid image format (only GIF, JPEG, PNG)</b><br>';
                                }
                            } else {
                                echo '<b>cannot open '.htmlentities($_FILES['userfile']['tmp_name']).'</b><br>';
                            }
                        } else {
                            echo '<b>!is_uploaded_file('.htmlentities($_FILES['userfile']['tmp_name']).')</b><br>';
                        }
                    } else {
                        echo '<b>WARNING:</b> Can only embed images for ID3v2<br>';
                    }
                }

                $tagwriter->tag_data = $TagData;
                if ($tagwriter->WriteTags()) {
                    echo 'Successfully wrote tags<BR>';
                    if (!empty($tagwriter->warnings)) {
                        echo 'There were some warnings:<blockquote style="background-color: #FFCC33; padding: 10px;">'.implode('<br><br>', $tagwriter->warnings).'</div>';
                    }
                } else {
                    echo 'Failed to write tags!<div style="background-color: #FF9999; padding: 10px;">'.implode('<br><br>', $tagwriter->errors).'</div>';
                }

            } else {

                echo 'WARNING: no tag formats selected for writing - nothing written';

            }
            echo '<HR>';

        }}
// }
