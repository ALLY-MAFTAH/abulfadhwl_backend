/* Abul Fadhwl admin — Kiswahili / English.
   One list of [kiswahili, english] pairs. Any text on the page that matches either
   side is shown in the chosen language, so old English pages and new Swahili pages
   both switch. "{}" matches a value (a number or a name) and is carried across.
   To translate a new label, just add a pair here. */
(function () {
  var P = [
    // ---- shell ----
    ['Mwanzo', 'Start'], ['Dashibodi', 'Dashboard'], ['Turaath', 'Heritage'], ['Sauti', 'Audio'], ['Vitabu', 'Books'], ['Makala', 'Articles'],
    ['Historia', 'History'], ['Slides', 'Slides'], ['Mawasiliano', 'Communication'], ['Matangazo', 'Announcements'], ['Maswali & Majibu', 'Questions & Answers'],
    ['Maoni', 'Comments'], ['Arifa (Push)', 'Notifications (Push)'], ['Mfumo', 'System'], ['Live / Matangazo ya moja kwa moja', 'Live broadcasts'],
    ['Viungo', 'Links'], ['Watumiaji', 'Users'], ['Usimamizi / Admin', 'Admin'], ['Msimamizi', 'Administrator'], ['Tovuti', 'Website'],
    ['Toka', 'Log out'], ['Mwanga / Giza', 'Light / Dark'], ['Mandhari', 'Theme'], ['Lugha', 'Language'],
    // ---- common ----
    ['Rudi', ['Back', 'Go back']], ['Hifadhi', ['Save', 'Add', 'Update']], ['Funga', ['Close', 'Cancel']], ['Ghairi', 'Cancel'], ['Futa', 'Delete'], ['Hariri', 'Edit'],
    ['Ongeza', 'Add'], ['Jina', 'Name'], ['Maelezo', 'Description'], ['Kichwa', 'Title'], ['Ujumbe', 'Message'], ['Namba', 'Number'], ['Tafuta', 'Search'],
    ['Tafuta:', 'Search:'], ['Fungua', ['Open', 'View']], ['Yote', ['All', 'See all']], ['Jibu', 'Answer'], ['Tuma', ['Send', 'Submit']],
    ['Hakuna', 'None'], ['Imetumwa', 'Sent'], ['Imeshindwa', 'Failed'], ['Inasubiri', 'Pending'], ['Haijathibitishwa', 'Unconfirmed'], ['Wewe', 'You'],
    ['Nyuma', 'Previous'], ['Mbele', 'Next'], ['Onyesha', 'Show'], ['maingizo', 'entries'], ['Hakuna data kwenye jedwali', 'No data available in table'],
    ['Inaonyesha {} hadi {} kati ya {}', 'Showing {} to {} of {} entries'], ['Onyesha {} maingizo', 'Show {} entries'],
    // ---- dashboard ----
    ['Assalamu alaykum wa rahmatullah, {}', 'Assalamu alaykum wa rahmatullah, {}'],
    ['Barakallahu feekum kwa kazi ya kueneza elimu yenye manufaa.', 'Barakallahu feekum for your work spreading beneficial knowledge.'],
    ['Pakia sauti', 'Upload audio'], ['Tangazo', 'Announcement'], ['Darsa ya moja kwa moja', 'Live lesson'], ['Weka sasa', 'Set it now'], ['Simamia', 'Manage'],
    ['Maswali yanayosubiri jibu', 'Questions waiting for an answer'], ['Hakuna maswali yanayosubiri. Alhamdulillah.', 'No questions waiting. Alhamdulillah.'],
    ['Vilivyopakiwa karibuni', 'Recently uploaded'], ['Kitabu', 'Book'], ['Maoni ya karibuni', 'Latest comments'], ['Hakuna maoni bado.', 'No comments yet.'],
    ['Njia za haraka', 'Quick links'], ['Tuma arifa', 'Send notification'], ['Bado hujaweka kiungo cha live.', 'You have not set a live link yet.'],
    ['Inarushwa sasa. Watumiaji wanaiona kwenye app.', 'Live now. Users can see it in the app.'],
    // ---- audio: categories, albums ----
    ['Turaath · Sauti', 'Heritage · Audio'], ['Makundi ya sauti', 'Audio categories'], ['Chagua kundi ufungue albamu zake, kisha pakia sauti ndani ya albamu.', 'Pick a category to open its albums, then upload audio inside an album.'],
    ['Kundi jipya', 'New category'], ['{} albamu', '{} albums'], ['Futa kundi hili?', 'Delete this category?'], ['Albamu na sauti zake zote zitafutwa.', 'The albums and all their audio will be deleted.'],
    ['Kundi la sauti', 'Audio category'], ['Hariri kundi', 'Edit category'], ['Albamu mpya', 'New album'], ['{} zimezimwa', '{} switched off'],
    ['Futa albamu hii?', 'Delete this album?'], ['Sauti zote ndani yake zitafutwa.', 'All audio inside it will be deleted.'],
    ['{} · Albamu', '{} · Album'], ['{} sauti', '{} audios'], ['{} zinaonekana', '{} visible'], ['Hariri albamu', 'Edit album'],
    ['Weka sauti hapa', 'Drop audio here'], ['Buruta folda nzima au faili nyingi. Tutazipanga kwa majina yake, kisha unahariri na kupakia zote kwa mkupuo.', 'Drag a whole folder or many files. We will list them by name, then you edit and upload them all at once.'],
    ['Chagua folda', 'Choose folder'], ['Chagua faili', 'Choose files'], ['Zinasubiri kupakiwa', 'Waiting to upload'], ['Safisha majina', 'Clean names'], ['Futa orodha', 'Clear list'],
    ['Pakia zote', 'Upload all'], ['Pakia zote ({})', 'Upload all ({})'], ['Inapakia…', 'Uploading…'], ['Inapakia… {} / {}', 'Uploading… {} / {}'],
    ['Sauti zilizomo ndani ya albamu hii', 'Audio in this album'], ['Buruta kupanga. Mpangilio unahifadhiwa papo hapo.', 'Drag to reorder. The order is saved instantly.'],
    ['kupanga. Mpangilio unahifadhiwa papo hapo.', 'to reorder. The order is saved instantly.'], ['Buruta', 'Drag'],
    ['Panga A–Z', 'Sort A–Z'], ['Washa zote', 'Switch all on'], ['Zima zote', 'Switch all off'], ['Tafuta sauti…', 'Search audio…'], ['Hakuna sauti bado', 'No audio yet'],
    ['Buruta folda juu ili kuanza.', 'Drag a folder above to start.'], ['Zilizozimwa hazionekani kwenye app lakini hazifutwi. Kubonyeza jina kunaruhusu kulihariri.', 'Switched-off audio is hidden in the app but not deleted. Click a name to edit it.'],
    ['Onyesha kwenye app', 'Show in the app'], ['Sikiliza', 'Listen'], ['Simamisha', 'Stop'], ['Ondoa mistari-chini, namba za mwanzo na nafasi nyingi', 'Remove underscores, leading numbers and extra spaces'],
    ['{} zinasubiri kupakiwa', '{} waiting to upload'], ['Zote zimepakiwa', 'All uploaded'], ['Imepakiwa', 'Uploaded'], ['Weka jina', 'Enter a name'], ['Jina hili lipo tayari', 'This name already exists'],
    ['{} zina tatizo la jina', '{} have a name problem'], ['hariri majina, washa/zima, au panga kwa kuburuta', 'edit names, switch on/off, or reorder by dragging'],
    ['Faili kubwa kuliko kikomo cha server ({})', 'File larger than the server limit ({})'], ['Mtandao umekatika', 'Network lost'], ['Hitilafu {}', 'Error {}'],
    ['Faili ni kubwa kuliko kikomo cha server', 'File is larger than the server limit'], ['Mpangilio umehifadhiwa', 'Order saved'], ['Inaonekana kwenye app', 'Visible in the app'],
    ['Imefichwa kwenye app', 'Hidden in the app'], ['Jina limebadilishwa', 'Name changed'], ['Futa sauti hii?', 'Delete this audio?'],
    ['"{}" itafutwa kabisa pamoja na faili lake.', '"{}" will be deleted permanently along with its file.'], ['Imefutwa', 'Deleted'], ['Imeshindwa kucheza faili hili', 'Could not play this file'],
    ['Hakuna faili la sauti lililopatikana', 'No audio files found'], ['Faili {} zisizo za sauti ziliruka', '{} non-audio files were skipped'], ['Majina yamesafishwa', 'Names cleaned'],
    ['Rekebisha majina yenye tatizo kwanza', 'Fix the names with problems first'], ['Sauti zote zimepakiwa', 'All audio uploaded'], ['Zimeshindikana {}. Rekebisha na ubonyeze Pakia tena.', '{} failed. Fix them and press Upload again.'],
    ['Futa albamu nzima?', 'Delete the whole album?'], ['Sauti zote ndani ya "{}" zitafutwa.', 'All audio inside "{}" will be deleted.'], ['Futa albamu', 'Delete album'],
    ['Andika maudhui kwanza', 'Write some content first'],
    // ---- live ----
    ['Matangazo ya moja kwa moja', 'Live broadcasts'], ['Andika darsa za wiki (kila kitabu safu moja). Washa swichi ya darsa inayoendelea sasa. Zingine zote zinazimwa zenyewe.', 'List the week\'s lessons (one row per book). Switch on the lesson happening now. All others turn off by themselves.'],
    ['Ongeza darsa', 'Add lesson'], ['Sikiliza live', 'Listen live'], ['Hakuna darsa bado', 'No lessons yet'], ['Bonyeza "Ongeza darsa" kuandika kitabu cha kwanza cha wiki.', 'Press "Add lesson" to enter the first book of the week.'],
    ['Ratiba ya wiki (picha)', 'Weekly timetable (image)'], ['Picha moja inayoonekana kwa darsa zote kwenye app', 'One image shown for all lessons in the app'], ['Itatumika na darsa zote.', 'It is used by all lessons.'],
    ['Badilisha picha ya ratiba', 'Change timetable image'], ['Pakia picha ya ratiba', 'Upload timetable image'], ['Darsa mpya', 'New lesson'], ['Kitabu / Kichwa', 'Book / Title'], ['Siku na wakati', 'Day and time'],
    ['Link ya live (YouTube / nyingine)', 'Live link (YouTube / other)'], ['Hariri darsa', 'Edit lesson'], ['Link ya live', 'Live link'], ['Sikiliza darsa hii', 'Listen to this lesson'],
    ['Hakuna darsa ya moja kwa moja sasa', 'No live lesson right now'], ['Washa swichi ya darsa ili kuanza kurusha.', 'Switch a lesson on to start broadcasting.'], ['Inarushwa sasa. Watumiaji wa app wanaiona.', 'Live now. App users can see it.'],
    ['Anza live: {}?', 'Start live: {}?'], ['Darsa nyingine zote zitazimwa, na arifa itatumwa kwa watumiaji wote wa app.', 'All other lessons will be switched off, and a notification will be sent to all app users.'],
    ['Washa live', 'Go live'], ['Maliza live?', 'End live?'], ['Watumiaji watapata arifa kuwa darsa imekwisha.', 'Users will be notified that the lesson has ended.'], ['Zima', 'Off'],
    ['Iko live sasa', 'It is live now'], ['Imezimwa', 'Switched off'], ['Futa darsa hii?', 'Delete this lesson?'], ['"{}" itafutwa.', '"{}" will be deleted.'],
    ['Link hii si ya sauti moja kwa moja. Imefunguliwa kwenye ukurasa mpya.', 'This link is not a direct audio stream. It was opened in a new tab.'],
    // ---- users ----
    ['Wasimamizi', 'Administrators'], ['Watu wanaoweza kuingia kwenye dashibodi hii. Kila msimamizi anaona na kubadilisha kila kitu.', 'People who can sign in to this dashboard. Every administrator can see and change everything.'],
    ['Ongeza msimamizi', 'Add administrator'], ['Msimamizi mpya', 'New administrator'], ['Email', 'Email'], ['Nenosiri', 'Password'], ['Thibitisha nenosiri', 'Confirm password'],
    ['Angalau herufi 8.', 'At least 8 characters.'], ['Hariri msimamizi', 'Edit administrator'], ['Nenosiri jipya (hiari)', 'New password (optional)'], ['Thibitisha nenosiri jipya', 'Confirm new password'],
    ['Acha wazi kama hutaki kubadilisha nenosiri.', 'Leave empty if you do not want to change the password.'], ['Futa msimamizi huyu?', 'Delete this administrator?'], ['{} hataweza kuingia tena.', '{} will no longer be able to sign in.'],
    // ---- notifications ----
    ['Mawasiliano · Push', 'Communication · Push'], ['Arifa', 'Notifications'], ['Tuma arifa kwa watumiaji wote wa app. Kila utumaji unaandikwa kwenye historia pamoja na jibu halisi la Firebase, na unaweza kutuma tena arifa ya zamani bila kuandika upya.', 'Send a notification to all app users. Every send is logged in the history with Firebase\'s actual reply, and you can resend an old notification without retyping it.'],
    ['Arifa mpya', 'New notification'], ['Watumiaji wote', 'All users'], ['Link ya picha (hiari)', 'Image link (optional)'], ['Kichwa cha arifa', 'Notification title'], ['Ujumbe utaonekana hapa kama kwenye simu.', 'The message will look like this on the phone.'],
    ['Tuma kwa wote', 'Send to everyone'], ['Historia ya arifa ({})', 'Notification history ({})'], ['Bonyeza "Tuma tena" au "Tumia tena" kutumia arifa ya zamani', 'Press "Resend" or "Reuse" to use an old notification'],
    ['imetumwa tena', 'resent'], ['Tuma tena', 'Resend'], ['Tumia tena', 'Reuse'], ['Hakuna arifa bado', 'No notifications yet'], ['Arifa utakazotuma zitaonekana hapa.', 'Notifications you send will appear here.'],
    ['mf. Darsa inaanza sasa', 'e.g. The lesson starts now'], ['Maelezo mafupi', 'Short description'], ['Kitambulisho cha Firebase', 'Firebase ID'], ['Weka kwenye fomu ili uhariri', 'Put it in the form to edit'], ['Futa kwenye historia', 'Delete from history'],
    ['Tuma kwa watumiaji wote?', 'Send to all users?'], ['"{}" itatumwa sasa kwa kila mtu mwenye app.', '"{}" will be sent now to everyone with the app.'], ['Tuma sasa', 'Send now'], ['Inatuma…', 'Sending…'],
    ['Tuma tena kwa wote?', 'Resend to everyone?'], ['"{}" itatumwa upya sasa na kuandikwa kama utumaji mpya kwenye historia.', '"{}" will be sent again now and logged as a new send in the history.'],
    ['Imewekwa kwenye fomu. Hariri kisha tuma.', 'Placed in the form. Edit, then send.'], ['Futa kwenye historia?', 'Delete from history?'], ['Imefutwa kwenye historia', 'Deleted from history'],
    // ---- history ----
    ['Turaath · Historia', 'Heritage · History'], ['Historia ya Sheikh', 'The Sheikh\'s history'], ['Sehemu zinaonekana kwenye app kwa mpangilio wa namba. Kila sehemu ina kichwa na maandishi marefu yenye mapambo.', 'Sections appear in the app in number order. Each section has a heading and a long formatted text.'],
    ['Sehemu mpya', 'New section'], ['Hariri sehemu', 'Edit section'], ['Bado hakuna historia', 'No history yet'], ['Bonyeza "Sehemu mpya" kuandika ya kwanza, mf. kuzaliwa kwake.', 'Press "New section" to write the first one, e.g. his birth.'],
    ['Andika kwa uhuru kama kwenye document. Mpangilio na mapambo yote yataonekana kwenye app kama ulivyoyaweka.', 'Write freely, as in a document. All layout and formatting will appear in the app as you set it.'],
    ['Kichwa cha sehemu', 'Section heading'], ['Hifadhi sehemu', 'Save section'], ['{} maneno', '{} words'], ['Futa sehemu hii?', 'Delete this section?'],
    ['Kidokezo: usiweke rangi nyeusi au nyeupe kabisa kwenye maandishi. App ina mandhari ya giza na mwanga, na rangi hizo zinaweza kutoweka kwenye mojawapo. Rangi ya kawaida ya maandishi inajirekebisha yenyewe.', 'Tip: do not use pure black or pure white for text. The app has a dark and a light theme, and such colours can vanish in one of them. The default text colour adjusts itself.'],
    // ---- legacy pages (English → Kiswahili) ----
    ['Ongeza tangazo', 'Add Announcement'], ['TANGAZO ({})', 'ANNOUNCEMENTS ({})'], ['Tarehe', 'Date'], ['Habari', 'News'], ['Hariri tangazo', 'Edit Announcement'],
    ['MAONI ({})', 'COMMENTS ({})'], ['Jina kamili', 'Full Name'], ['Simu', 'Phone'], ['Zote', 'All'], ['Zilizojibiwa', 'Answered'], ['Zisizojibiwa', 'Unanswered'],
    ['MASWALI YOTE ({})', 'MASWALI YOTE ({})'], ['Swali', 'Swali'], ['Jibu la maandishi', 'Jibu la maandihsi'], ['Weka jibu', 'Add answer'],
    ['Ongeza kiungo', 'Add Link'], ['VIUNGO ({})', 'LINKS ({})'], ['Aikoni', 'Icon'], ['Kiungo', 'Url'], ['Aina', 'Type'], ['Washa', 'Switch'], ['Hariri kiungo', 'Edit Link'], ['--Chagua--', '--Select--'],
    ['Ongeza slide', 'Add Slide'], ['SLIDES ({})', 'SLIDES ({})'], ['Slide Na: ', 'Slide No:'],
    ['Ongeza kitabu', 'Add Book'], ['VITABU ({})', 'BOOKS ({})'], ['Jalada', 'Cover'], ['Toleo', 'Edition'], ['Mwaka wa kuchapishwa', 'Year of Publish'], ['Hariri kitabu', 'Edit Book'], ['Taarifa za kitabu', 'Book Information'],
    ['Ongeza makala', 'Add Article'], ['MAKALA ({})', 'ARTICLES ({})'], ['Namba ya makala', 'Article Number'], ['Hariri makala', 'Edit Article'], ['Taarifa za makala', 'Article Information'],
    ['Mwandishi:', 'Author:'], ['Maelezo:', 'Description:'], ['Kichwa:', 'Title:'], ['Mwaka wa kuchapishwa:', 'Year of Publishment:'], ['Toleo:', 'Edition:'], ['Namba ya makala:', 'Article Number:'],
    ['SAUTI ZOTE', 'ALL AUDIOS'], ['Albamu', 'Album'], ['Kundi', 'Category'], ['Idadi ya sauti', 'No. of Audios'], ['ALBAMU', 'ALBUMS'], ['Hariri sauti', 'Edit Audio'],
    ['Ongeza', 'Add Link'],
    // ---- history reading view + delete confirmations ----
    ['Panua zote', 'Expand all'], ['Funga zote', 'Collapse all'], ['Hariri sehemu hii', 'Edit this section'],
    ['Hii ni muonekano wa kusoma tu. Hakuna kinachobadilika hapa.', 'This is a read-only view. Nothing changes here.'],
    ['Futa hii?', 'Delete this?'], ['Una uhakika?', 'Are you sure?'], ['Ndiyo', 'Yes'],
    ['Albamu hii itafutwa', 'This album will be deleted'], ['Tangazo hili litafutwa', 'This announcement will be deleted'], ['Jibu hili litafutwa', 'This answer will be deleted'],
    ['Makala hii itafutwa', 'This article will be deleted'], ['Kitabu hiki kitafutwa', 'This book will be deleted'], ['Maoni haya yatafutwa', 'This comment will be deleted'],
    ['Kiungo hiki kitafutwa', 'This link will be deleted'], ['Slide hii itafutwa', 'This slide will be deleted'], ['Sauti hii itafutwa', 'This song will be deleted'],
    // ---- consistency pass ----
    ['MASWALI YOTE ({})', 'ALL QUESTIONS ({})'],
    ['MASWALI YASIYOJIBIWA ({})', 'UNANSWERED QUESTIONS ({})'],
    ['MASWALI YALIYOJIBIWA ({})', 'ANSWERED QUESTIONS ({})'],
    ['Swali', 'Question'],
    ['Swali Lililoulizwa', 'Question asked'],
    ['Jibu la maandishi', 'Text answer'],
    ['Jibu la maandihsi', 'Text answer'],
    ['Jibu la sauti', 'Audio answer'],
    ['Jibu la audios', 'Audio answer'],
    ['Yote', 'All'],
    ['Zilizojibiwa', 'Answered'],
    ['Zisizojibiwa', 'Unanswered'],
    ['Weka jibu', 'Add answer'],
    ['Assalamu alaykum wa rahmatullah, {}', 'Assalamu alaykum wa rahmatullah, {}'],
    ['Arifa hii itaondolewa kwenye orodha. Haiwezi kuvutwa kutoka kwenye simu zilizokwisha ipokea.', 'This notification will be removed from the list. It cannot be pulled back from phones that already received it.'],
    ['SLIDES ({})', 'SLIDES ({})'],
    ['Faili', 'File'],
    ['Faili la sauti', 'Audio File'],
    ['Mwaka wa kuchapishwa', 'Year of Publishment'],
    ['Live', 'Live'],
    ['mf. Sharhu Thalathatil Usul', 'e.g. Sharhu Thalathatil Usul'],
    ['mf. Jumatatu baada ya Magharibi', 'e.g. Monday after Maghrib'],
    ['Taarifa za historia', 'History Information'],
    ['Sehemu:', 'Section:'],
    ['Kichwa:', 'Heading:'],
    ['Maudhui:', 'Content:'],
    ['Hariri historia', 'Edit History'],
    ['Sehemu', 'Section'],
    ['Kichwa cha habari', 'Heading'],
    ['Maudhui', 'Content'],
    ['Anza kuandika hapa, au bandika kutoka Word / Google Docs…', 'Start writing here, or paste from Word / Google Docs…'],
    ['mf. Kuzaliwa kwake na malezi', 'e.g. His birth and upbringing'],
    ['Sauti zote ndani ya', 'All audio inside'],
    ['Swali halipatikani', 'Question not found'],
    ['Swali limehaririwa', 'Question Edited Successfully'],
    ['Swali limefutwa', 'Question Deleted Successfully'],
    ['Swali lililojibiwa halipo', 'Answered Question does not exist'],
    ['Albamu imeongezwa', 'Album added successfully'],
    ['Albamu imehaririwa', 'Album edited successfully'],
    ['Albamu imefutwa', 'Album deleted successfully'],
    ['Albamu haipo', 'Album does not exists'],
    ['Albamu haipatikani', 'Album not found'],
    ['Darsa haipatikani', 'Stream not found'],
    ['Darsa imefutwa', 'Stream deleted successfully'],
    ['Darsa haipo', 'Stream does not exist'],
    ['Ratiba haipatikani', 'Timetable not found'],
    ['Slide imeongezwa', 'Slide added successfully'],
    ['Slide imefutwa', 'Slide deleted successfully'],
    ['Slide haipo', 'Slide does not exist'],
    ['Slide haipo', 'Slide not exists'],
    ['Kiungo kimeongezwa', 'Link added successfully'],
    ['Kiungo kimehaririwa', 'Link edited successfully'],
    ['Kiungo kimebadilishwa', 'Link Switched Successfully'],
    ['Kiungo kimefutwa', 'Link deleted successfully'],
    ['Kiungo hakipatikani', 'Link not found'],
    ['Kiungo hakipo', 'Link does not exist'],
    ['Kitabu kimeongezwa', 'Book added successfully'],
    ['Kitabu kimehaririwa', 'Book edited successfully'],
    ['Kitabu kimefutwa', 'Book deleted successfully'],
    ['Ongeza faili la kitabu', 'Add a book file'],
    ['Ongeza jalada la kitabu', 'Add a book cover'],
    ['Kitabu hakipo', 'Book does not exist'],
    ['Kitabu hakipo', 'Book not exists'],
    ['Kitabu hakipatikani', 'Book not found'],
    ['Maoni yamefutwa', 'Comment deleted successfully'],
    ['Maoni hayapatikani', 'Comment not found'],
    ['Maoni hayapo', 'Comment does not exist'],
    ['Sauti zimeongezwa', 'Audio Files Added Successfully'],
    ['Sauti imehaririwa', 'Audio edited successfully'],
    ['Sauti imefutwa', 'Audio deleted successfully'],
    ['Sauti haipatikani', 'Song not found'],
    ['Sauti hazipatikani', 'Songs not found'],
    ['Ongeza faili la sauti', 'Add an audio file'],
    ['Sauti haipo', 'Song not exists'],
    ['Albamu haipo', 'Album not found'],
    ['Jina hili tayari lipo. Litumie jina lingine.', 'This name already exists. Use another name.'],
    ['Sauti haipo', 'Audio not found'],
    ['Jina haliwezi kuwa tupu', 'The name cannot be empty'],
    ['Jina hili tayari lipo', 'This name already exists'],
    ['Sehemu haipo', 'Section not found'],
    ['Sehemu ya historia imefutwa', 'History deleted successfully'],
    ['Historia haipatikani', 'History not found'],
    ['Maudhui ni tupu', 'content is empty'],
    ['Historia haipo', 'History does not exist'],
    ['Makala imeongezwa', 'Article added successfully'],
    ['Makala imehaririwa', 'Article edited successfully'],
    ['Makala imefutwa', 'Article deleted successfully'],
    ['Ongeza faili la makala', 'Add a article file'],
    ['Makala haipo', 'Article does not exist'],
    ['Makala haipo', 'Article not exists'],
    ['Kundi limeongezwa', 'Category added successfully'],
    ['Kundi limehaririwa', 'Category edited successfully'],
    ['Kundi limefutwa', 'Category deleted successfully'],
    ['Kundi halipo', 'Category does not exist'],
    ['Tangazo limeongezwa', 'Announcement added successfully'],
    ['Tangazo limehaririwa', 'Announcement edited successfully'],
    ['Tangazo limefutwa', 'Announcement deleted successfully'],
    ['Tangazo halipatikani', 'Announcement not found'],
    ['Tangazo halipo', 'Announcement does not exist'],
    // ---- other languages ----
    ['Lugha nyingine', 'Other languages'], ['(hiari — ukiacha wazi, Kiswahili kinatumika)', '(optional — if left empty, Kiswahili is used)'], ['Habari / Tangazo', 'News / Announcement'],
    // ---- structured timetable ----
    ['Kichwa cha live', 'Live title'], ['mf. LIVE - DARSA YA HADITHI', 'e.g. LIVE - DARSA YA HADITHI'], ['mf. الجوهر النقي الملتقط من أحاديث النبي ﷺ', 'e.g. الجوهر النقي الملتقط من أحاديث النبي ﷺ'],
    ['Jina la kitabu kwenye ratiba (hiari)', 'Book name in the timetable (optional)'], ['mf. Al Jawharun Naqiyyu', 'e.g. Al Jawharun Naqiyyu'], ['Likiachwa wazi, kichwa cha juu kinatumika', 'If left empty, the main title is used'],
    ['Kichwa kidogo (hiari)', 'Subtitle (optional)'], ['Kinaonekana chini ya kichwa ukiwa live', 'Shown under the title while live'],
    ['Siku', 'Day'], ['Muda', 'Time'], ['Mwalimu', 'Teacher'], ['— Chagua siku —', '— Choose a day —'], ['Ratiba ya wiki', 'Weekly timetable'],
    ['Hivi ndivyo ratiba inavyoonekana kwenye app. Chagua siku na mwalimu kwenye kila darsa.', 'This is how the timetable looks in the app. Pick a day and teacher on each lesson.'],
    ['Ratiba bado haina siku', 'The timetable has no days yet'], ['Hariri kila darsa uchague siku (na mwalimu), kisha ratiba itatokea hapa na kwenye app.', 'Edit each lesson and pick a day (and teacher); the timetable will then appear here and in the app.'],
    ['Jumatatu', 'Monday'], ['Jumanne', 'Tuesday'], ['Jumatano', 'Wednesday'], ['Alhamisi', 'Thursday'], ['Ijumaa', 'Friday'], ['Jumamosi', 'Saturday'], ['Jumapili', 'Sunday'],
    ['mf. Baada ya Magharibi', 'e.g. After Maghrib'], ['mf. Abul Fadhwl', 'e.g. Abul Fadhwl'],
    // ---- Hijri calendar ----
    ['Kalenda ya Hijri', 'Hijri Calendar'], ['KALENDA YA HIJRI: Mwanzo wa mwezi (kwa kuonekana mwezi)', 'HIJRI CALENDAR: Start of the month (by moon sighting)'],
    ['Mwezi ukishaonekana (au idadi ya siku 30 kukamilika), ingiza hapa tarehe ya kawaida (Gregorian) ya siku ya kwanza ya mwezi huo wa Hijri. Programu itatumia tarehe hii badala ya hesabu. Miezi ambayo haijaingizwa inaonyeshwa kama makadirio.', 'Once the moon has been sighted (or 30 days are complete), enter the Gregorian date of the first day of that Hijri month. The app uses this date instead of calculation. Months not entered are shown as estimates.'],
    ['Mwezi wa Hijri', 'Hijri month'], ['Mwaka (H)', 'Year (H)'], ['Siku ya 1 (tarehe ya kawaida)', 'Day 1 (Gregorian date)'], ['Maelezo (si lazima)', 'Note (optional)'],
    ['mf. Mwezi umeonekana Tanga', 'e.g. Moon sighted in Tanga'], ['Miezi iliyothibitishwa ({})', 'Confirmed months ({})'], ['Mwezi', 'Month'], ['Mwaka', 'Year'],
    ['Ulianza (siku ya 1)', 'Started (day 1)'], ['Kufuta mwezi huu?', 'Delete this month?'], ['Bado hakuna mwezi uliothibitishwa.', 'No confirmed month yet.'],
    ['Imehifadhiwa: mwezi {}, {}H', 'Saved: month {}, {}H'],
    ['{}. Swafar', '{}. Safar'], ['{}. Rabiul Awwal', '{}. Rabi al-Awwal'], ['{}. Rabiul Thaani', '{}. Rabi al-Thani'], ['{}. Jumaadal Uulaa', '{}. Jumada al-Awwal'], ['{}. Jumaadal Aakhira', '{}. Jumada al-Thani'], ['{}. Shaaban', '{}. Sha\'ban'], ['{}. Ramadhani', '{}. Ramadan'], ['{}. Shawwaal', '{}. Shawwal'],
    // ---- server flash messages ----
    ['Msimamizi ameongezwa', 'Administrator added'], ['Msimamizi amefutwa', 'Administrator deleted'], ['Taarifa zimehifadhiwa', 'Details saved'], ['Sehemu imeongezwa', 'Section added'], ['Sehemu imehifadhiwa', 'Section saved'],
    ['Huwezi kujifuta mwenyewe.', 'You cannot delete yourself.'], ['Lazima abaki msimamizi angalau mmoja.', 'At least one administrator must remain.'], ['Ratiba ya wiki imesasishwa', 'Weekly timetable updated'],
    ['Darsa imeongezwa', 'Lesson added'], ['Darsa imehaririwa', 'Lesson edited'], ['Darsa iko LIVE sasa', 'The lesson is LIVE now'], ['Darsa imezimwa', 'The lesson was switched off'],
    ['Firebase imekubali arifa ({}). Kitambulisho: {}', 'Firebase accepted the notification ({}). ID: {}'], ['Arifa HAIKUTUMWA: {}', 'Notification NOT sent: {}']
  ];

  // ---- build lookup ----
  function norm(s) { return String(s).replace(/\s+/g, ' ').trim(); }
  function esc(s) { return s.replace(/[.*+?^$()|[\]\\]/g, '\\$&'); }
  var exact = { sw: {}, en: {} }, pats = [];
  P.forEach(function (p) {
    var sw = p[0], ens = Array.isArray(p[1]) ? p[1] : [p[1]], en = ens[0];
    [[sw, 'sw'], ].concat(ens.map(function (e) { return [e, 'en']; })).forEach(function (x) {
      var text = x[0], side = x[1];
      if (text.indexOf('{}') < 0) { exact[side][norm(text).toLowerCase()] = [sw, en]; return; }
      var parts = norm(text).split('{}');
      pats.push({ re: new RegExp('^' + parts.map(esc).join('(.+?)') + '$', 'i'), sw: sw, en: en, side: side });
    });
  });

  function fill(tpl, vals) { var i = 0; return tpl.replace(/\{\}/g, function () { return vals[i++] || ''; }); }

  function tr(str, lang) {
    var n = norm(str); if (!n) return str;
    var hit = exact.sw[n.toLowerCase()] || exact.en[n.toLowerCase()];
    if (hit) return hit[lang === 'en' ? 1 : 0];
    for (var i = 0; i < pats.length; i++) {
      var m = n.match(pats[i].re);
      if (m) return fill(pats[i][lang === 'en' ? 'en' : 'sw'], m.slice(1));
    }
    return str;
  }

  var lang = 'sw';
  try { lang = localStorage.getItem('af-lang') || 'sw'; } catch (e) {}

  var AFx = window.AF = window.AF || {};
  AFx.tr = tr; AFx.t = function (s) { return tr(s, lang); }; AFx.lang = function () { return lang; };

  // ---- DOM ----
  var SKIP = /^(SCRIPT|STYLE|TEXTAREA|CODE|PRE|NOSCRIPT)$/;
  var busy = false;
  function skipEl(el) { return !el || SKIP.test(el.nodeName) || (el.closest && el.closest('[data-no-i18n],.jodit-container,.jodit-wysiwyg,[contenteditable="true"]')); }

  function textNodes(root, fn) {
    var w = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null), n, list = [];
    while ((n = w.nextNode())) list.push(n);
    list.forEach(fn);
  }
  function doNode(n) {
    if (skipEl(n.parentNode)) return;
    var v = n.nodeValue; if (!v || !v.trim()) return;
    var m = v.match(/^(\s*)([\s\S]*?)(\s*)$/), t = tr(m[2], lang);
    if (t !== m[2]) n.nodeValue = m[1] + t + m[3];
  }
  function doAttrs(root) {
    var els = root.querySelectorAll ? root.querySelectorAll('[placeholder],[title],[aria-label],input[type=submit],input[type=button]') : [];
    [].forEach.call(els, function (el) {
      if (skipEl(el)) return;
      ['placeholder', 'title', 'aria-label'].forEach(function (a) { if (el.hasAttribute(a)) { var v = el.getAttribute(a), t = tr(v, lang); if (t !== v) el.setAttribute(a, t); } });
      if (/^(submit|button)$/i.test(el.type || '') && el.value) { var t2 = tr(el.value, lang); if (t2 !== el.value) el.value = t2; }
    });
  }
  function run(root) {
    busy = true;
    try { textNodes(root, doNode); doAttrs(root); } finally { busy = false; }
  }

  function setLang(l) {
    lang = l === 'en' ? 'en' : 'sw';
    try { localStorage.setItem('af-lang', lang); } catch (e) {}
    document.documentElement.lang = lang;
    run(document.body);
    [].forEach.call(document.querySelectorAll('[data-setlang]'), function (b) { b.classList.toggle('on', b.dataset.setlang === lang); });
  }
  AFx.setLang = setLang;

  function start() {
    document.documentElement.lang = lang;
    run(document.body);
    [].forEach.call(document.querySelectorAll('[data-setlang]'), function (b) {
      b.classList.toggle('on', b.dataset.setlang === lang);
      b.addEventListener('click', function () { setLang(b.dataset.setlang); });
    });
    new MutationObserver(function (muts) {
      if (busy) return;
      busy = true;
      try {
        muts.forEach(function (m) {
          if (m.type === 'characterData') doNode(m.target);
          m.addedNodes && [].forEach.call(m.addedNodes, function (a) {
            if (a.nodeType === 3) doNode(a);
            else if (a.nodeType === 1 && !skipEl(a)) { textNodes(a, doNode); doAttrs(a); }
          });
        });
      } finally { busy = false; }
    }).observe(document.body, { childList: true, subtree: true, characterData: true });
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start); else start();
})();
