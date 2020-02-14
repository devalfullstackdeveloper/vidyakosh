<?php

return array (
  'backend' => 
  array (
    'courses' =>  
    array (
      'title' => 'Courses',  
      'fields' =>  
      array (
        'published' => 'Published',
        'featured' => 'Featured',
        'free' => 'Free',
        'trending' => 'Trending',
        'popular' => 'Popular', 
        'teachers' => 'Teachers',
        'category' => 'Category',
        'subcategory' => 'Sub Category',
        'title' => 'Title',
        'moodle_course_ref_id' => 'Moodle Reference ID',
        'course_enrollment_type' => 'Course Enrollment Type',
        'slug' => 'Slug',
        'description' => 'Description',
        'price' => 'Price',
        'course_image' => 'Course Image',
        'start_date' => 'Start Date',
        'meta_title' => 'Meta Title',
        'meta_description' => 'Meta Description',
        'meta_keywords' => 'Meta Keywords',
        'sidebar' => 'Add Sidebar',
        'lessons' => 
        array (
          'add' => 'Add Lessons',
          'view' => 'View Lessons',
        ),
        'course' => 'Course',
        'status' => 'Status',
      ),
      'add_teachers' => 'Add Teachers',
      'add_categories' => 'Add Categories',
      'slug_placeholder' => 'Input slug or it will be generated automatically',
      'select_category' => 'Select Category',
      'select_teachers' => 'Select Teachers',
      'test' => 'Test',
      'lesson' => 'Lesson', 
      'create' => 'Create Course',
      'edit' => 'Edit Course',
      'view' => 'View Courses',
      'category' => 'Category',
      'save_timeline' => 'Save timeline', 
      'course_timeline' => 'Course timeline',
      'timeline_description' => 'Drag and change sequence of Lessons/Tests for course',
      'listing_note' => 'Only Published Lessons and Tests will be Displayed and Sorted.',
    ),
    'tests' => 
    array (
      'title' => 'Tests',
      'fields' => 
      array (
        'course' => 'Course',
        'lesson' => 'Lesson',
        'title' => 'Title',
        'description' => 'Description',
        'published' => 'Published',
        'questions' => 'Questions',
      ),
      'create' => 'Create Test',
      'edit' => 'Edit Test',
      'view' => 'View Tests',
    ),
    'orders' => 
    array (
      'fields' => 
      array (
        'payment_status' => 
        array (
          'pending' => 'Pending',
          'completed' => 'Completed',
          'failed' => 'Failed',
          'title' => 'Payment',
        ),
        'payment_type' => 
        array (
          'stripe' => 'Credit / Debit Card (Stripe Payment Gateway)',
          'paypal' => 'Paypal',
          'offline' => 'Offline',
          'title' => 'Payment Type',
        ),
        'reference_no' => 'Reference No.',
        'ordered_by' => 'Ordered By',
        'items' => 'Items',
        'amount' => 'Amount',
        'user_email' => 'User Email',
        'date' => 'Order date',
      ),
      'complete' => 'Complete Manually',
      'offline_requests' => 'Offline Requests',
      'view_invoice' => 'View Invoice',
      'download_invoice' => 'Download Invoice',
      'title' => 'Orders',
    ),
    'pages' => 
    array (
      'fields' => 
      array (
        'published' => 'Published',
        'drafted' => 'Drafted',
        'title' => 'Title',
        'slug' => 'Slug',
        'featured_image' => 'Featured image',
        'content' => 'Content',
        'meta_title' => 'Meta Title',
        'meta_description' => 'Meta Description',
        'meta_keywords' => 'Meta Keywords',
        'clear' => 'Clear',
        'status' => 'Status',
        'created' => 'Created',
        'created_at' => 'Created On',
      ),
      'max_file_size' => '(max file size 10MB)',
      'title' => 'Pages',
      'create' => 'Create Page',
      'edit' => 'Edit Page',
      'view' => 'View Pages',
    ),
    'access' => 
    array (
      'users' => 
      array (
        'user_actions' => 'User Actions',
        'management' => 'User Management',
        'change_password' => 'Change Password',
        'change_password_for' => 'Change Password for :user',
        'create' => 'Create User',
        'table' => 
        array (
          'abilities' => 'Abilities',
          'total' => 'user total|users total',
          'confirmed' => 'Confirmed',
          'created' => 'Created',
          'email' => 'E-mail',
          'id' => 'ID',
          'last_updated' => 'Last Updated',
          'name' => 'Name',
          'first_name' => 'First Name',
          'last_name' => 'Last Name',
          'no_deactivated' => 'No Deactivated Users',
          'no_deleted' => 'No Deleted Users',
          'other_permissions' => 'Other Permissions',
          'permissions' => 'Permissions',
          'roles' => 'Roles',
          'social' => 'Social',
          'status' => 'Status',
        ),
        'all_permissions' => 'All Permissions',
        'deactivated' => 'Deactivated Users',
        'deleted' => 'Deleted Users', 
        'edit' => 'Edit User',
        'active' => 'Active Users',
        'view' => 'View User',
        'tabs' => 
        array (
          'titles' => 
          array (
            'overview' => 'Overview',
            'history' => 'History',
          ),
          'content' => 
          array (
            'overview' => 
            array (
              'avatar' => 'Avatar',
              'confirmed' => 'Confirmed',
              'created_at' => 'Created At',
              'deleted_at' => 'Deleted At',
              'email' => 'E-mail',
              'last_login_at' => 'Last Login At',
              'last_login_ip' => 'Last Login IP',
              'last_updated' => 'Last Updated',
              'name' => 'Name',
              'first_name' => 'First Name',
              'last_name' => 'Last Name',
              'status' => 'Status',
              'timezone' => 'Timezone',
            ),
          ),
        ),
        'no_permissions' => 'No Permissions',
        'no_roles' => 'No Roles to set.',
        'permissions' => 'Permissions',
      ),
      'roles' => 
      array (
        'management' => 'Role Management',
        'create' => 'Create Role',
        'edit' => 'Edit Role',
        'faculty' => 'Faculty',
        'table' => 
        array (
          'total' => 'role total|roles total',
          'number_of_users' => 'Number of Users',
          'permissions' => 'Permissions',
          'role' => 'Role',
          'sort' => 'Sort',
        ),
      ),
    ),
    'blogs' => 
    array (
      'fields' => 
      array (
        'title' => 'Title',
        'category' => 'Category',
        'slug' => 'Slug',
        'featured_image' => 'Featured image',
        'content' => 'Content',
        'tags_placeholder' => 'Add tags here',
        'meta_title' => 'Meta Title',
        'meta_description' => 'Meta Description',
        'meta_keywords' => 'Meta Keywords',
        'publish' => 'Publish',
        'clear' => 'Clear',
        'status' => 'Status',
        'views' => 'Action',
        'created' => 'Created',
        'comments' => 'Comments',
        'tags' => 'Tags',
        'created_at' => 'Created On',
      ),
      'max_file_size' => '(max file size 10MB)',
      'title' => 'Blog',
      'create' => 'Create Blog',
      'edit' => 'Edit Blog',
      'view' => 'View Blogs',
    ),
    'lessons' => 
    array (
      'slug_placeholder' => 'Input slug or it will be generated automatically',
      'fields' => 
      array (
        'course' => 'Course',
        'title' => 'Title',
        'slug' => 'Slug',
        'lesson_image' => 'Lesson Image',
        'short_text' => 'Short Text',
        'full_text' => 'Full Text',
        'downloadable_files' => 'Downloadable Files',
        'free_lesson' => 'Free Lesson',
        'published' => 'Published',
        'position' => 'Position',
        'youtube_videos' => 'YouTube Videos',
        'add_pdf' => 'Add PDF',
        'add_video' => 'Add Video',
        'media_video' => 'Media Video',
        'media_audio' => 'Media Audio',
        'media_pdf' => 'Media PDF',
        'add_audio' => 'Add Audio',
      ),
      'max_file_size' => '(max file size 5MB)',
      'short_description_placeholder' => 'Input short description of lesson',
      'select_course' => 'Select Course',
      'yt_note' => '<b>Instructions to add Video link: </b><br> Go to youtube -> open video -> right click on video and <b>Copy Video URL</b> and paste here.<br> If you want to add multiple videos, then separate them with <b>,</b> (Comma) Sign.',
      'vimeo_note' => '<b>Instructions to add Video link: </b><br> Go to vimeo -> open video -> right click on video and <b>Copy Video URL</b> and paste here.<br> If you want to add multiple videos, then separate them with <b>,</b> (Comma) Sign.',
      'title' => 'Lessons',
      'enter_video_url' => 'Enter video data',
      'enter_video_embed_code' => 'Enter video embed code',
      'create' => 'Create Lesson',
      'edit' => 'Edit Lesson',
      'view' => 'View Lessons',
      'video_guide' => '<p class="mb-1"><b>Youtube :</b> Go to Youtube -> Go to video you want to display -> click on share button below video. Copy that links and paste in above text box </p>
<p class="mb-1"><b>Vimeo :</b> Go to Vimeo -> Go to video you want to display -> click on share button and copy paste video url here </p>
<p class="mb-1"><b>Upload :</b> Upload <b>mp4</b> file in file input</p>
<p class="mb-1"><b>Embed :</b> Copy / Paste embed code in above text box</p>',
      'remove' => 'Remove',
    ),
    'categories' => 
    array (
      'fields' => 
      array (
        'name' => 'Name',
        'select_icon' => 'Select Icon',
        'image' => 'Image',
        'icon' => 'Icon',
		'moodle_cat_ref_id' => 'Moodle Reference ID',
        'icon_type' => 
        array (
          'title' => 'Icon type',
          'select_any' => 'Select Any',
          'image' => 'Upload image',
          'icon' => 'Select Icon',
        ),
        'or' => 'Or',
        'slug' => 'Slug',
        'courses' => 'Courses',
        'status' => 'Status',
      ),
      'title' => 'Categories',
      'create' => 'Create Category',
      'edit' => 'Edit Category',
      'view' => 'View Categories',
    ),
    'faqs' => 
    array (
      'fields' => 
      array (
        'question' => 'Question',
        'answer' => 'Answer',
        'category' => 'Category',
        'status' => 'Status',
      ),
      'title' => 'FAQs',
      'create' => 'Create FAQ',
      'edit' => 'Edit FAQ',
      'view' => 'View FAQs',
    ),
    'invoices' => 
    array (
      'fields' => 
      array (
        'view' => 'View',
        'download' => 'Download',
        'order_date' => 'Order Date',
        'amount' => 'Amount',
      ),
      'title' => 'Invoices',
    ),
    'menu-manager' => 
    array (
      'title' => 'Menu Manager',
    ),
    'messages' => 
    array (
      'compose' => 'Compose',
      'search_user' => 'Search User',
      'select_recipients' => 'Select Recipients',
      'start_conversation' => 'Start a conversation',
      'type_a_message' => 'Type a message',
      'title' => 'Messages',
    ),

'trainings' => 
    array (
      'fields' => 
      array (
        'view' => 'Action',
        'download' => 'Download',
        'last_nominee' => 'Last Date of Nomination',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'title'=>'Training Title',
        'approved'=>'Approved',
        'reject'=>'Reject'
      ),
      'title' => 'UpComing Training',
      'upcomming' => 'UpComing Training'
    ),

    'status' => 
    array (
      'fields' => 
      array (
        'nomination_date' => 'Last Date of Nomination',
        'status'=>'Status',
        'title'=>'Training Title',
        'name'=>'Approved / Rejected By', 
      ),
      'title' => 'Training Status',
    ),

     'feedbacks' => 
    array (
      'fields' => 
      array (
        'start_date' => 'Nomination Date', 
        'status'=>'Status',
        'title'=>'Training Title',
        'name'=>'Approved / Reject By', 
      ),
      'title' => 'Feedback',

    ),


 'feedbacks' => 
    array (
      'fields' => 
      array (
        'start_date' => 'Nomination Date',
        'status'=>'Status',
        'title'=>'Training Title',
        'name'=>'Approved / Reject By',
        'training_id'=> 'Training Name',
        'topic'=>'1. About the usefulness of Training on above said topic. *',
        'ratings'=>'Rating For Above:',
        'faculties'=>'2. About the quality of presentations(Contents, coverage etc.) made by the Faculties. *',
        'prospective'=>'3. Specify the topics you would like to add or delete from the Training for future prospective. *',
        'rate'=>'4. How would you rate the organization of this training programme? Please tick. *',
        'structure'=>'Course Structure',
        'interaction'=>'Interaction with faculty',
        'venue'=>'Venue',
        'arrangement'=>'5. How did you find the all-round arrangement of the program at Location of the venue*',
        'location'=>'Venue Location',
        'coordination'=>'6. What are your comments on the coordination of the program from the side of NIC ?*', 
        'coordinationrating'=>'Rating For Above:',
        'activities'=>'7. Do you find yourself more capable for handling activities after the training? *',
        'capability'=>'Capability',
        'utilizing'=>'8. What are the future plans of utilizing the acquired skills in your ongoing projects?*',
        'suggestions'=>'9. Any other suggestions.',
        'overall'=>'10. Overall Rating*',
        'feedback_placeholder' => 'Please Input Your Response Here',

      ),
      'title' => 'Feedback',
      'create' => 'Create Feedback'
    ),


    'approvals' => 
    array (
      'fields' => 
      array (
        'nomination_date' => 'Last Date of Nomination',
        'title'=>'Training Title', 
        'name'=>'Requested By',
      ),
      'title'=>'Request for Approval',
    ),


    'approveds' => 
    array (
      'fields' => 
      array (
        'date' => 'Approved Date',
        'title'=>'Training Title',
        'request'=>'Requested By',
         'requestdate'=>'Request Date',
        'name'=>'Approved By',
        'action'=>'Action',
      ),
      'title' => 'Approved Training',
    ),

     'rejects' => 
    array (
      'fields' => 
      array (
        'date' => 'Rejected Date',
        'name' => 'Rejected By',
        'request' => 'Requested By',
        'requestdate' => 'Requested Date',
        'title'=>'Training Title',
        'action'=>'Action',
      ),
      'title' => 'Rejected Training',
    ),

     'trainingviews' => 
    array (
      'fields' => 
      array (
        'title'=>'Training Title',
        'deptname'=>'Department Name',
        'trackname'=>'Track Name',
        'category'=>'Category Name',
        'year'=>'Year Name',
        'state'=>'State Name',
        'city'=>'City Name',
        'venue'=>'Venue',
        'designation'=>'Designation Name',
        'start'=>'Start Date',
        'end' => 'End Date',
        'nomination' => 'Nomination Date',
        'description' => 'Description',
        'time' => 'Training Time',
        'city' => 'City Name',
        
      ),
      'title' => 'Training View',
    ),
    

  'attendedtraings' => 
    array (
      'fields' => 
      array (
        'date' => 'End Date',
        'request' => 'Requested By',
        'title'=>'Training Title',
      ),
      'title' => 'Attended Training',
    ),


'attended' => 
    array (
      'fields' => 
      array (
        'nomination_date' => 'Last Date of Nomination',
        'start' => 'Start Date',
        'end' => 'End Date',
        'title'=>'Training Title',
        'name'=> 'Requested By',
      ),
      'title' => 'Attended Training',
    ),



    'menu-manager' => 
    array (
      'title' => 'Menu Manager',
    ),
    'messages' => 
    array (
      'compose' => 'Compose',
      'search_user' => 'Search User',
      'select_recipients' => 'Select Recipients',
      'start_conversation' => 'Start a conversation',
      'type_a_message' => 'Type a message',
      'title' => 'Messages',
    ),
    'learnings' => 
    array (
      'title' => 'E-Learning Courses',
    ),
    'questions' => 
    array (
      'fields' => 
      array (
        'question' => 'Question',
        'question_image' => 'Question Image',
        'score' => 'Score',
        'tests' => 'Tests',
        'option_text' => 'Option Text',
        'correct' => 'Correct',
        'course' => 'Course',
        'lesson' => 'Lesson',
        'title' => 'Title',
        'option_explanation' => 'Option Explanation',
      ),
      'title' => 'Questions',
      'create' => 'Create Question',
      'edit' => 'Edit Question',
      'view' => 'View Questions',
      'test' => 'Test',
    ),
    'reasons' => 
    array (
      'fields' => 
      array (
        'title' => 'Title',
        'icon' => 'Icon',
        'content' => 'Content',
        'status' => 'Status',
      ),
      'title' => 'Reasons',
      'create' => 'Create Reason',
      'edit' => 'Edit Reason',
      'view' => 'Action',
      'note' => 'Reasons will be displayed as a slider on homepage as below',
    ),
    'general_settings' => 
    array (
      'title' => 'General',
      'contact' => 
      array (
        'short_text' => 'Short Text', 
        'show' => 'Show',
        'primary_address' => 'Primary Address',
        'secondary_address' => 'Secondary Address',
        'primary_phone' => 'Primary Phone',
        'secondary_phone' => 'Secondary Phone',
        'primary_email' => 'Primary Email',
        'secondary_email' => 'Secondary Email',
        'location_on_map' => 'Location on Map',
        'map_note' => '<h3>How to embed Location for Map?</h3>
                                <p>Do following simple steps and you are good to go:</p>
                                <ol class="map-guide">
                                    <li>Go to <a class="text-bold" target="_blank" href="//maps.google.com">Google Map</a> </li>
                                    <li>Search the place you want to add by Entering address / location in input box located on upper-left corner</li>
                                    <li>Once you get the place you want. It shows details in left sidebar. Click on <i class="fa fa-share-alt text-primary"></i> button</li>
                                    <li>A popup will appear which will have two tabs <b>Send a link</b> and <b>Embed a Map</b></li>
                                    <li>Click on <b>Embed a map</b> It will show you chosen Place on Map</li>
                                    <li>Now click on the dropdown from the left. By default <b>Medium</b> is selected. Click on it and Select <b>Large</b></li>
                                    <li>Now Click on <b class="text-primary">COPY HTML</b> link from it and <b>Paste</b> that code here in <b>Location on Map</b>.</li>
                                </ol>',
        'title' => 'Contact',
        'primary_email_note' => 'This email will be used to correspond "Contact Us" emails',
      ),
      'footer' => 
      array (
        'short_description' => 'Short Description',
        'popular_categories' => 'Popular categories',
        'featured_courses' => 'Featured courses',
        'trending_courses' => 'Trending courses',
        'popular_courses' => 'Popular courses',
        'custom_links' => 'Custom Links',
        'social_links' => 'Social Links',
        'link_url' => 'URL',
        'social_links_note' => 'Add social link URL and select Icon for that media from iconpicker. Click on <b>ADD +</b> button. And your social link will be created. You can also delete them by clicking on <b><i class="fa fa-times"></i></b> button',
        'newsletter_form' => 'Newsletter Form',
        'bottom_footer' => 'Bottom Footer',
        'bottom_footer_note' => 'Note : it includes Copyright text and Footer links',
        'copyright_text' => 'Copyright Text',
        'footer_links' => 'Footer Links',
        'link_label' => 'Label',
        'link' => 'Link',
        'title' => 'Footer',
        'section_1' => 'Section 1',
        'section_2' => 'Section 2',
        'section_3' => 'Section 3',
        'recent_news' => 'Recent News',
      ),
      'logos' => 
      array (
        'title' => 'Logos',
      ),
      'layout' => 
      array (
        'title' => 'Layout',
      ),
      'email' => 
      array (
        'title' => 'Mail Configuration',
        'mail_from_name' => 'Mail From Name',
        'mail_from_name_note' => 'This will be display name for your sent email.',
        'mail_from_address' => 'Mail From Address',
        'mail_from_address_note' => 'This email will be used for "Contact Form" correspondence.',
        'mail_driver' => 'Mail Driver',
        'mail_driver_note' => 'You can select any driver you want for your Mail setup. <b>Ex. SMTP, Mailgun, Mandrill, SparkPost, Amazon SES etc.</b><br> Add <b>single driver only</b>.',
        'mail_host' => 'Mail HOST',
        'mail_port' => 'Mail PORT',
        'mail_username' => 'Mail Username',
        'mail_username_note' => 'Add your email id you want to configure for sending emails',
        'mail_password' => 'Mail Password',
        'mail_password_note' => 'Add your email password you want to configure for sending emails',
        'mail_encryption' => 'Mail Encryption',
        'mail_encryption_note' => 'Use <b>tls</b> if your site uses <b>HTTP</b> protocol and <b>ssl</b> if you site uses <b>HTTPS</b> protocol',
        'note' => '<b>Important Note</b> : IF you are using <b>GMAIL</b> for Mail configuration, make sure you have completed following process before updating:
 <ul>
<li>Go to <a target="_blank" href="https://myaccount.google.com/security">My Account</a> from your Google Account you want to configure and Login</li>
<li>Scroll down to <b>Less secure app access</b> and set it <b>ON</b></li>
</ul>',
      ),
      'payment_settings' => 
      array (
        'title' => 'Payment Configuration',
        'select_currency' => 'Select Currency',
        'stripe' => 'Stripe Payment Method',
        'stripe_note' => 'Enables payments in site with Debit / Credit Cards',
        'paypal' => 'Paypal Payment Method',
        'paypal_note' => 'Redirects to paypal for payment',
        'offline_mode' => 'Offline Payment Method',
        'offline_mode_note' => 'User gets assistance for offline payment via admin',
        'key' => 'API Key',
        'secret' => 'API Secret',
        'client_id' => 'Client ID',
        'client_secret' => 'Secret',
        'mode' => 'Mode',
        'sandbox' => 'Sandbox',
        'live' => 'Live',
        'how_to_stripe' => 'How to get STRIPE API Credentials?',
        'how_to_paypal' => 'How to get PayPal API Credentials?',
        'mode_note' => '<b>Sandbox</b>= Will be used for testing payments with PayPal Test Credentials. Account with USD only can make payments with PayPal for now. This options will redirect to test PayPal payment with Sandbox User Credentials. It will be used for dummy transactions only.<br>
<b>Live</b> = Will be used with you Live PayPal credentials to make actual transaction with normal users with PayPal account.',
        'bluesnap' => 'Bluesnap Payment Method',
        'bluesnap_note' => 'Bluesnap card form for payment',
        'how_to_bluesnap' => 'How to get Bluesnap API Credentials?',
      ),
      'management' => 'General Settings',
      'app_name' => 'App Name',
      'app_url' => 'App URL',
      'lesson_note' => 'Enable / Disable if user will be able to skip before timer is over.',
      'font_color' => 'Font Color',
      'static' => 'Static',
      'google_analytics_id' => 'Google Analytics ID',
      'google_analytics_id_note' => 'How to get Google Analytics ID?',
      'database' => 'Database / Real',
      'counter' => 'Counter',
      'counter_note' => '<b>Static</b> =  Manually add data for counter. Please enter exact text you want to display on frontend counter section,<br> <b>Database/Real</b> = It will take real data from database for all the fields (Students enrolled, Total Courses, Total Teachers)',
      'total_students' => 'Enter Total Students. Ex: 1K, 1Million, 1000 etc.',
      'total_courses' => 'Enter Total Courses. Ex: 1K, 1000 etc.',
      'total_teachers' => 'Enter Total Teachers. Ex: 1K, 1000 etc.',
      'layout_type' => 'Layout Type',
      'theme_layout' => 'Theme Layout',
      'layout_note' => 'This will change frontend theme layout',
      'show_offers_note' => 'Enable / Disable if Coupon offers page link to be displayed in bottom footer',
      'newsletter' => 
      array (
        'mail_provider' => 'Mail Service Provider',
        'mailchimp' => 'Mailchimp',
        'sendgrid' => 'SendGrid',
        'mail_provider_note' => '<b>Note </b>: You can select any Mail service provider to receive all the emails which are being used to <b>subscribe newsletter</b>.<br> Select and setup according to steps given. <b>It is compulsory</b>, if you want to use <b>newsletter subscription</b> form.',
        'api_key' => 'API Key',
        'api_key_note' => 'Generate <b>API key</b> from your <a target="_blank" href="https://mailchimp.com/"><b> Mailchimp account</b></a> and paste that in above text box.',
        'api_key_question' => 'How to generate API key?',
        'list_id' => 'List ID',
        'list_id_note' => 'Find and paste <b>List ID</b> in above box',
        'list_id_question' => 'How to find List ID from Mailchimp?',
        'double_opt_in' => 'Double Opt-in',
        'double_opt_in_note' => '<b>On</b> = User will be asked in mail to opt in for subscription. <b>Off</b> = User will be directly subscribed for newsletter ',
        'api_key_note_sendgrid' => 'Generate <b>API key</b> from your <a target="_blank" href="https://sendgrid.com/"><b> SendGrid account</b></a> and paste that in above text box.',
        'get_lists' => 'Get Lists',
        'sendgrid_lists' => 'SendGrid Email Lists',
        'select_list' => 'Select List',
        'manage_lists' => 'Manage SendGrid Lists',
        'create_new' => 'Create and Select New',
        'title' => 'Newsletter Configuration',
        'list_id_question_sendgrid' => 'Create new Email list for SendGrid Here.',
      ),
      'mail_configuration_note' => 'Have you configured :link Mail Settings</a>? It is compulsory to setup to send/receive emails',
      'app_locale' => 'App Locale',
      'app_timezone' => 'App Timezone',
      'mail_driver' => 'Mail Driver',
      'mail_host' => 'Mail Host',
      'mail_port' => 'Mail Port',
      'mail_from_name' => 'Mail From Name',
      'mail_from_address' => 'Mail From Address',
      'mail_username' => 'Mail Username',
      'mail_password' => 'Mail Password',
      'enable_registration' => 'Enable Registration',
      'change_email' => 'Change Email',
      'password_history' => 'Password History',
      'password_expires_days' => 'Password Expires Days',
      'requires_approval' => 'Requires Approval',
      'confirm_email' => 'Confirm Email',
      'homepage' => 'Select Homepage',
      'captcha_status' => 'Captcha Status',
      'captcha_site_key' => 'Captcha Key',
      'captcha_site_secret' => 'Captcha Secret',
      'google_analytics' => 'Google Analytics Code',
      'sections_note' => 'Once you click on update, you will see list of sections to on/off.',
      'general' => 
      array (
        'title' => 'General',
      ),
      'captcha' => 'Whether the registration - login captcha is on or off',
      'captcha_note' => 'How to get Google reCaptcha credentials?',
      'retest_note' => 'Enable / Disable if user will be able to give retest for same exam',
      'language_settings' => 
      array (
        'title' => 'Language Settings',
        'default_language' => 'Default Language',
        'right_to_left' => 'Right to Left',
        'left_to_right' => 'Left to right',
        'display_type' => 'Display Type',
      ),
      'user_registration_settings' => 
      array (
        'title' => 'User Registration Settings',
        'desc' => 'Checked fields from the right sidebar will be displayed in registration form',
        'fields' => 
        array (
          'first_name' => 'First Name',
          'last_name' => 'Last Name',
          'email' => 'Email',
          'password' => 'Password',
          'phone' => 'Phone',
          'dob' => 'Date of Birth',
          'gender' => 'Gender',
          'male' => 'Male',
          'female' => 'Female',
          'other' => 'Other',
          'address' => 'Address',
          'pincode' => 'Pincode',
          'country' => 'Country',
          'state' => 'State',
          'city' => 'City',
        ),
      ),
      'troubleshoot' => 'Troubleshoot',
      'onesignal_note' => 'Enable / Disble OneSignal configuration for Website.',
      'how_to_onesignal' => 'How to create app in OneSignal?',
      'setup_onesignal' => 'How to set up OneSignal?',
    ),
    'logo' => 
    array (
      'logo_b' => 'Logo 1',
      'logo_b_note' => 'Note : Upload logo with <b>black text and transparent background in .png format</b> and <b>294x50</b>(WxH) pixels.<br> <b>Height</b> should be fixed, <b>width</b> according to your <b>aspect ratio</b>.',
      'logo_w' => 'Logo 2',
      'logo_w_note' => 'Note : Upload logo with <b>white text and transparent background in .png format</b> and <b>294x50</b> (WxH) pixels.<br> <b>Height</b> should be fixed, <b>width</b> according to your <b>aspect ratio</b>.',
      'logo_white' => 'Logo 3',
      'logo_white_note' => 'Note : Upload logo with <b>only in white text and transparent background in .png format</b> and <b>294x50</b>(WxH)  pixels.<br> <b>Height</b> should be fixed, <b>width</b> according to your <b>aspect ratio</b>.',
      'logo_popup' => 'Logo for Popups',
      'logo_popup_note' => 'Note : Add square logo minimum resolution <b>72x72</b> pixels',
      'favicon' => 'Add Favicon',
      'favicon_note' => 'Note : Upload logo with resolution <b>32x32</b> pixels and extension <b>.png</b> or <b>.gif</b> or <b>.ico</b>',
      'title' => 'Change Logo',
    ),
    'social_settings' => 
    array (
      'management' => 'Social Settings',
      'fb_note' => 'Enable / disable facebook login for website',
      'fb_api_note' => 'How to get Facebook API Credentials?',
      'google_api_note' => 'How to get Google API Credentials?',
      'twitter_api_note' => 'How to get Twitter API Credentials?',
      'google_note' => 'Enable / disable Google login for website',
      'twitter_note' => 'Enable / disable Twitter login for website',
      'linkedin_api_note' => 'How to get LinkedIn API Credentials?',
      'linkedin_note' => 'Enable / disable LinkedIn login for website',
    ),
	
	'default_website_page' => 
    array (
      'title' => 'Default Website Landing Page',
    ),
	
    'hero_slider' => 
    array (
      'fields' => 
      array (
        'name' => 'Name',
        'bg_image' => 'BG Image',
        'overlay' => 
        array (
          'title' => 'Overlay',
          'note' => 'If you turn it on. A black overlay will be displayed on your image. It will be helpful when BG image is not darker or does not have Overlay',
        ),
        'hero_text' => 'Hero Text',
        'sub_text' => 'Sub Text',
        'widget' => 
        array (
          'title' => 'Widget',
          'input_date_time' => 'Input date and time',
          'select_widget' => 'Select Widget',
          'search_bar' => 'Search Bar',
          'countdown_timer' => 'Countdown Timer',
        ),
        'buttons' => 
        array (
          'title' => 'Buttons',
          'add' => 'Add',
          'placeholder' => 'Add number of buttons you want to add',
          'note' => 'Note: Maximum 4 buttons can be added. Please add label and link for the button for redirecting action when button is clicked.',
          'name' => 'Button',
          'label' => 'Label',
          'link' => 'Link',
        ),
        'sequence' => 'Sequence',
        'status' => 'Status',
      ),
      'note' => 'Note: Please upload .jpg or .png in <b>1920x900</b> resolution for best result. Use darker or Overlayed images for better result.',
      'on' => 'On',
      'off' => 'Off',
      'title' => 'Hero Slider',
      'create' => 'Create Slide',
      'edit' => 'Edit Slide',
      'view' => 'View Slides',
      'manage_sequence' => 'Manage Sequence of Slides',
      'sequence_note' => 'Drag and change sequence of a Slide',
      'save_sequence' => 'Save Sequence',
    ),
    'tax' => 
    array (
      'title' => 'Tax',
      'create' => 'Create Tax',
      'edit' => 'Edit Tax',
      'view' => 'View Tax',
      'on' => 'On',
      'off' => 'Off',
      'fields' => 
      array (
        'name' => 'Name',
        'rate' => 'Rate',
        'status' => 'Status',
      ),
    ),
    'coupons' => 
    array (
      'title' => 'Coupons',
      'create' => 'Create Coupon',
      'edit' => 'Edit Coupon',
      'view' => 'View Coupons',
      'courses' => 'Courses',
      'bundles' => 'Bundles',
      'on' => 'On',
      'off' => 'Off',
      'flat_rate' => 'Flat Rate',
      'discount_rate' => 'Discount Rate',
      'type_note' => '<b>Discount Rate (%) :</b> If you will select this, it will apply rate in % to total purchase. Ex. Price = $100 and Discount rate is 10% then 10% of 100$ will be deducted.<br><b>Flat Rate : </b>If you select this, particular amount will be deducted from total purchase. Ex. Price = 100$ and Flat rate is 25$ then 25$ will be deducted from 100$.',
      'amount_note' => 'If <b>Discount Rate</b> selected, input rate of percentage. If <b>Flat Rate</b> selected, input particular amount to be deducted.',
      'per_user_limit_note' => 'Specify how many times a single user can use this coupon. By default one time use.',
      'total_note' => 'Number of coupons to be issued',
      'fields' => 
      array (
        'name' => 'Name',
        'code' => 'Code',
        'type' => 'Type',
        'for' => 'For',
        'amount' => 'Amount',
        'expires_at' => 'Expires At',
        'per_user_limit' => 'Per User Limit',
        'total' => 'Total',
        'status' => 'Status',
        'min_price' => 'Minimum Order Price',
        'description' => 'Description',
      ),
      'description' => 'Description',
      'unlimited' => 'Unlimited',
    ),
    'sponsors' => 
    array (
      'title' => 'Sponsors',
      'fields' => 
      array (
        'name' => 'Name',
        'link' => 'Link',
        'logo' => 'Logo',
        'status' => 'Status',
      ),
      'create' => 'Create Sponsors',
      'edit' => 'Edit Sponsors',
      'view' => 'View Sponsors',
    ),
    'teachers' => 
    array (
      'fields' => 
      array (
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email Address',
        'password' => 'Password',
        'image' => 'Image',
        'status' => 'Status',
      ),
      'title' => 'Teachers',
      'create' => 'Create Teacher',
      'edit' => 'Edit Teacher',
      'view' => 'View Teachers',
    ),
	
   'ministry' => 
    array (
      'fields' => 
      array (
        'ministry_name' => 'Ministry Name',
        'status' => 'Status',
      ),
      'title' => 'Ministry',
      'create' => 'Create Ministry',
      'edit' => 'Edit Ministry',
      'view' => 'View Ministry',
    ),
	
  'departments' => 
    array (
      'fields' => 
      array (
        'department_name' => 'Department Name',
	     'ministry_id' => 'Ministry Name',
        'status' => 'Status',
        'logo'=>'Logo'
      ),
      'title' => 'Departments',
      'create' => 'Create Department',
      'edit' => 'Edit Department',
      'view' => 'View Department',
    ),
	
	'states' => 
    array (
      'fields' => 
      array (
        'state' => 'State Name',
        'status' => 'Status',
      ),
      'title' => 'States',
      'create' => 'Create State',
      'edit' => 'Edit State',
      'view' => 'View State',
    ),
		'cities' => 
    array (
      'fields' => 
      array (
        'city' => 'City Name',
        'status' => 'Status',
      ),
      'title' => 'Cities',
      'create' => 'Create City',
      'edit' => 'Edit City',
      'view' => 'View Cities',
    ),
	
     'locations' => 
    array (
      'fields' => 
      array (
        'office_name' => 'Office Name',
        'address'=>'Address',
        'status' => 'Status',
        'contact' => 'Contact Number',
        'email' => 'Email Address',
        'contact' => 'Contact Number'
      ),
      'title' => 'Office Locations',
      'create' => 'Create Office Location',
      'edit' => 'Edit Office Location',
      'view' => 'View Office Location',
    ),
	
	'subcategories' => 
    array (
      'fields' => 
      array (
        'name' => 'Sub Category Name',
		'cat_name'=>'Category Name',
		'moodle_subcat_ref_id' => 'Moodle Reference ID',
        'status' => 'Status',
      ),
      'title' => 'Sub Categories',
      'create' => 'Create Subcategory',
      'edit' => 'Edit Subcategory',
      'view' => 'View Subcategory',
    ),
	
 'news' => 
    array (
      'fields' => 
      array (
        'title' => 'Title',
		'description' => 'Description',
		'start_date' => 'Start date',
		'end_date' => 'End date',
        'status' => 'Status',
      ),
      'title' => 'News Flash',
      'create' => 'Create NewsFlash',
      'edit' => 'Edit NewsFlash',
      'view' => 'View NewsFlash',
    ),
	
	  'designations' => 
    array (
      'fields' => 
      array (
    'designation' => 'Designation Name',
		'ministry_id' => 'Ministry Name',
		'department_id' => 'Department Name',
		'office_id' => 'Office Name',
    'status' => 'Status',
    'desig'=>'Designation',
    'reportingmanager_id'=>'Reporting Manager Name',
    'parent_designation_id'=>'Parents'
      ),
      'title' => 'Designation',
      'create' => 'Create Designation',
      'edit' => 'Edit Designation',
      'view' => 'View Designation',
    ),

     'faculty' => 
    array (
            'fields' =>
            array(
                'department_id' => 'Department Name',
                'institute_industry_id' => 'Institute Industry Name',
                'name' => 'Name',
                'role' => 'Role',
                'designation' => 'Designation',
                'mobile' => 'Mobile',
                'email' => 'Email',
                'address' => 'Address',
                'subject' => 'Subjects',
                'status' => 'Status',
            ),
            'title' => 'Faculty',
            'create' => 'Create Faculty',
            'edit' => 'Edit Faculty',
            'view' => 'View Faculty',
        ),
		
		
		'training-type' => 
    array (
            'fields' =>
            array(
                'department_id' => 'Department Name',
                'title1' => 'Title',
                'name' => 'Name',
                'status' => 'Status',
                'designation' => 'Designation',
                'created_at' => 'Created At',
                'email' => 'Email',
                'updated_at' => 'Updated At',
                'deleted_at' => 'Deleted At',
            ),
            'title' => 'Training Type',
            'create' => 'Create Training Type',
            'edit' => 'Edit Training Type',
            'view' => 'View Training Type',
        ),
		
		

     'years' => 
    array (
      'fields' => 
      array (
    'department_id' => 'Department Name',
    'name' => 'Year Name',
    'year' => 'Year',
    'status' => 'Status',
      ),
      'title' => 'Year',
      'create' => 'Create Year',
      'edit' => 'Edit Year',
      'view' => 'View Year',
    ),

     'venues' => 
    array (
      'fields' => 
      array ( 
    'department_id' => 'Department Name',
    'state' => 'State Name',
    'city' => 'City Name',
    'address' => 'Address',
      ),
      'title' => 'Venue',
      'create' => 'Create Venue',
      'edit' => 'Edit Venue',
      'view' => 'View Venue',
    ),

	
	'nominations' => 
    array (
      'fields' => 
      array ( 
    'department_id' => 'Department Name',
    'training_types' => 'Trainings',
      ),
      'title' => 'Nominations',
      'create' => 'Create Nominations',
      'edit' => 'Edit Nominations',
      'view' => 'View Nominations',
    ),
    

    'sectionofficers' => 
    array (
      'fields' => 
      array (
    'department_id' => 'Department Name',
    'officer_id' => 'Officer Name',
      ),
      'title' => 'Section Officer',
      'create' => 'Create Section Officer',
      'edit' => 'Edit Section Officer',
      'view' => 'View Section Officer',
    ),




    'signings' => 
    array (
      'fields' => 
      array (
    'department_id' => 'Department Name',
    'office_id' => 'Office Name',
    'officer_id' => 'Officer Name',
      ),
      'title' => 'Signing Authority ',
      'create' => 'Create Signing Authority',
      'edit' => 'Edit Signing Authority',
      'view' => 'View Signing Authority',
    ),
	
	'officeorder' => 
		array (
            'fields' =>
            array(
                'department_id' => 'Department Name',
                'nomination_type' => 'Nomination Type',
                'training_id' => 'Training',
                'signing_authority' => 'Signing Authority',
                'file_no' => 'File No.',
                'action' => 'Action',
                'emp_code' => 'Employee Code',
                'name' => 'Name',
                'designation' => 'Designation',
                'empcode' => 'Empcode',
                'email'=> 'Email',
                'state' => 'State',
                'action' => 'Action',
            ),
            'title' => 'Office Order',
            'create' => 'Create Office Order',
            'edit' => 'Edit Office Order',
            'view' => 'View Office Order',
        ),
    'crts' => 
    array (
      'fields' => 
      array (
    'department_id' => 'Department Name',
    'track_id' => 'Track Name',
    'category_id' => 'Category Name',
    'year_id' => 'Year Name',
    'state_id' => 'State Name',
    'city_id' => 'City Name',
    'venue_id' => 'Venue Name',
    'feedback' => 'Feedback',
    'title' => 'Title',
    'designation' => 'Level',
    'description' => 'Description',
    'coordinator' => 'Coordinator',
    'empcode' => 'Employee Code', 
    'instituteIndustry' => 'Institute / Industry Name',
    'resourceperson' => 'Resource Person',
    'timing'=>'Timing',
    'duration'=>'Training Duration',
    'startdate'=>'Start Date',
    'enddate'=>'End Date',
    'lastnominne'=>'Last Nomination',
    'start_date'=>'Start Date',
    'categoryname'=>'Category Name',
    'yearname'=>'Year Name',
    'statename'=>'State Name',
    'cityname'=>'City Name',
    'venu'=>'Venue Name',
    'designationname'=>'Designation Name',
    'title'=>'Title',
    'description'=>'Description',
    'coordinatecode'=>'Cordinate Employee Code',
    'coordinateid'=>'Cordinate  Institute Name',
    'resourceempcode'=>'Resource Employee code',
    'resourceinstituteid'=>'Resource Institute Name',
    'timing'=>'Timing',
    'faculty'=>'Faculty',
    'slot'=>'Slot',
    'training_for'=>'Training For',
    'training_type'=>'Training Type',
    'training_type'=>'Training Type',
    'inst_ind_id'=>'Institute Industry Id',
      ),
       'lessons' => 
        array (
          'empcode' => 'Enter Employee Code',
          'view' => 'View Lessons',
        ),
      'title' => 'CRT Training',
      'create' => 'Create CRT Training',
      'edit' => 'Edit CRT Training',
      'view' => 'View CRT Training',
    ),


   'attandences' => 
    array (
      'fields' => 
      array (
    'department_id' => 'Department Name',
    'name' => 'Name',
    'designation' => 'Designation',
    'present' => 'Present',
      ),
      'title' => 'Attandence',
      'create' => 'Create Attandence',
      'edit' => 'Edit Attandence',
      'view' => 'View Attandence',
    ),






     'tracks' => 
    array (
      'fields' => 
      array (
    'department_id' => 'Department Name',
    'name' => 'Track Name',
    'status' => 'Status',
      ),
      'title' => 'Track',
      'create' => 'Create Track',
      'edit' => 'Edit Track',
      'view' => 'View Track',
    ),
    
      'categories' => 
    array (
      'fields' => 
      array (
    'department_id' => 'Department Name',
    'name' => ' Name',
    'status' => 'Status',
    'moodle_course_ref_id' => 'Moodle Reference ID',
    'select_icon' => 'Select Icon',
    'slug' => 'Slug',
      ),
      'title' => 'Category',
      'create' => 'Create Category',
      'edit' => 'Edit Category',
      'view' => 'View Category',
    ),
	
   'institute-industry' => 
    array (
      'fields' => 
      array (
        'name' => 'Name',
		'phone' => 'Phone',
		'email' => 'Email',
		'address' => 'Address',
		'type_id' => 'Type',
        'status' => 'Status',
      ),
      'title' => 'Institute / Industry',
      'create' => 'Create Institute / Industry',
      'edit' => 'Edit Institute / Industry',
      'view' => 'View Institute / Industry',
    ),
	
	'banner' => 
    array (
      'fields' => 
      array (
        'title' => 'Title',
	    'banner_image' => 'Image',
        'status' => 'Status',
      ),
      'title' => 'Banners',
      'create' => 'Create Banner',
      'edit' => 'Edit Banner',
      'view' => 'View Banner',
    ),
	
    'testimonials' => 
    array (
      'fields' => 
      array (
        'name' => 'Name',
        'occupation' => 'Occupation',
        'content' => 'Content',
        'status' => 'Status',
      ),
      'title' => 'Testimonials',
      'create' => 'Create Testimonial',
      'edit' => 'Edit Testimonial',
      'view' => 'View Testimonials',
    ),
    'dashboard' => 
    array (
      'title' => 'Dashboard',
      'students' => 'Students',
      'trending' => 'Trending',
      'teachers' => 'Teachers',
      'completed' => 'Completed',
      'no_data' => 'No data available',
      'buy_course_now' => 'Buy course now',
      'your_courses' => 'Your Courses',
      'students_enrolled' => 'Students Enrolled To<br> Your Courses',
      'recent_reviews' => 'Recent Reviews',
      'recent_orders' => 'Recent Orders',
      'recent_contacts' => 'Recent Contacts',
      'view_all' => 'View All',
      'course' => 'Course',
      'review' => 'Review',
      'time' => 'Time',
      'recent_messages' => 'Recent Messages',
      'message' => 'Message',
      'message_by' => 'Message By',
      'courses' => 'Courses',
      'ordered_by' => 'Ordered By',
      'view' => 'View',
      'amount' => 'Amount',
      'recent_contact_requests' => 'Recent Contact Requests',
      'name' => 'Name',
      'email' => 'Email',
      'my_course_bundles' => 'My Course Bundles',
      'my_courses' => 'My Courses',
      'your_courses_and_bundles' => 'Your Courses and Bundles',
      'course_and_bundles' => 'Course and Bundles',
      'pending_orders' => 'Pending Orders',
      'pending' => 'Pending',
      'success' => 'Success',
      'failed' => 'Failed',
    ),
    'questions_options' => 
    array (
      'title' => 'Questions Option',
      'create' => 'Create Option',
      'edit' => 'Edit Option',
      'view' => 'View Question Options',
      'fields' => 
      array (
        'course' => 'Course',
        'lesson' => 'Lesson',
        'title' => 'Title',
        'question' => 'Question',
        'question_option' => 'Question Option',
        'score' => 'Score',
        'tests' => 'Tests',
        'option_text' => 'Option Text',
        'correct' => 'Correct',
      ),
    ),
    'reviews' => 
    array (
      'title' => 'Reviews',
      'fields' => 
      array (
        'course' => 'Course',
        'user' => 'User',
        'content' => 'Content',
        'time' => 'Time',
      ),
    ),
    'contacts' => 
    array (
      'title' => 'Leads',
      'fields' => 
      array (
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'message' => 'Message',
        'time' => 'Time',
      ),
    ),
    'translations' => 
    array (
      'title' => 'Translation Manager',
      'warning' => 'Warning, translations are not visible until they are exported back to the app/lang file, using
                        <code>php artisan translation:export</code> command or publish button.',
      'done_importing' => 'Done importing, processed <strong class="counter">N</strong> items! Reload this page to
                            refresh the groups!',
      'done_searching' => 'Done searching for translations, found <strong class="counter">N</strong> items!',
      'done_publishing_for_group' => 'Done publishing the translations for group',
      'done_publishing_for_all_groups' => 'Done publishing the translations for all group!',
      'append_new_translations' => 'Append new translations',
      'replace_existing_translations' => 'Replace existing translations',
      'import_groups' => 'Import Groups',
      'import_groups_note' => '<p>This will get all locale files from <code>lang</code> folder and insert into database.<br> <b>Append new translations :</b> It will append only new files and data <b>&amp;</b>
                                            <b>Replace existing translations:</b>It will replace existing records according to files</p>',
      'choose_a_group' => 'Choose a group to display the group translations. If no groups are visible, make sure
                                you have run the migrations and imported the translations.',
      'translation_warning' => 'Are you sure you want to publish the translations group :group ? This will overwrite existing language files',
      'publishing' => 'Publishing..',
      'publish_translations' => 'Publish Translations',
      'total' => 'Total',
      'changed' => 'Changed',
      'key' => 'Key',
      'supported_locales' => 'Supported Locales',
      'current_supported_locales' => 'Current Supported Locales',
      'enter_new_locale_key' => 'Enter new locale key',
      'add_new_locale' => 'Add new locale',
      'adding' => 'Adding...',
      'export_all_translations' => 'Export all translations',
      'publish_all' => 'Publish all',
      'publish_all_warning' => 'Are you sure you want to publish all translations group? This will overwrite existing language files.',
    ),
    'update' => 
    array (
      'title' => 'Update Theme',
      'upload' => 'Upload new version  <small>(update.zip)</small>',
      'current_version' => 'Current Version',
      'note_before_upload_title' => 'Read following notes before updating',
      'file_replaced' => 'Following files will be updated / replaced',
      'warning' => '<b>WARNING : We strongly recommend you to update theme by version number</b>.<br> <b>Example :</b> update_v1.zip, update_v2.zip. Please do not jump version number. If your version number is 1 and you want to update it, then update to version 2. Do no directly update to version 3.',
      'note_before_upload' => '<p><b>Please take BACKUP before updating.</b> Updated zip file may come with new folders and file updates. <b>Your current files will be replaced with new one</b>. So, <b>if you have made any changes in current application files it will be LOST</b>.</p>
                        <p>If you are directly uploading from below file input box, your files will be replaced. We strongly recommend you to do it manual replacement of files one by one or edit the changes by comparing your current edited file and new updated files.</p>
                        <p>If you still have confusion. Please contact us, we will guide you to update your application</p>',
    ),
    'backup' => 
    array (
      'title' => 'Backup',
      'email' => 'Email Notification',
      'app_token' => 'App Token',
      'app_secret' => 'App Secret',
      'api_key' => 'API Key',
      'app_key' => 'App Key',
      'api_secret' => 'API Secret',
      'enable_disable' => 'Enable / Disable',
      'backup_type' => 'Backup Type',
      'dropbox' => 'Dropbox',
      'backup_files' => 'Backup Files',
      'aws' => 'AWS S3',
      'db' => 'Database',
      'configuration' => 'Configuration',
      'generate_backup' => 'Generate Backup',
      'db_storage' => 'Database and Storage files',
      'db_app' => 'Database and Application files',
      'backup_schedule' => 'Backup Schedule',
      'daily' => 'Daily',
      'weekly' => 'Weekly',
      'monthly' => 'Monthly',
      'dropbox_note' => 'Please checkout documentation for <b>How to obtain DropBox App Keys?</b>',
      'region' => 'Region',
      'bucket_name' => 'Bucket Name',
      'backup_notice' => 'Please refer documentation before beginning backup. It has every details step by step for creating backup with Dropbox.',
      'backup_note' => '<b>Note </b>: To run this backup properly you need to add following code to your <b>CRON TAB:</b><br><code>* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1</code>',
    ),
    'certificates' => 
    array (
      'title' => 'Certificates',
      'fields' => 
      array (
        'course_name' => 'Course Name',
        'progress' => 'Progress',
        'action' => 'Action',
      ),
      'view' => 'View',
      'download' => 'Download',
    ),

    'peercompstatus' => 
    array (
      'title' => "PEER'S COURSE COMPLETION STATUS",
      'fields' => 
      array (
        'officer_name' => 'Officer Name',
        'place_postong' => 'Place of Posting',
        'email' => 'Email Id',
        'no_course'=>'No. of Courses Completed',
      ),
      'view' => 'View',
      'download' => 'Download',
    ),
     'resourcelist' => 
    array (
      'title' => "RESOURCE LIST",
      'fields' => 
      array (
        'resourcedepartment' => 'Department',
        'resourcetrack' => 'Resource Track',
        'resourcecat' => 'Resource Category',
        'resourcesubcat' => 'Resource Sub-Category',
        'resourcetitle' => 'Resource Title',
        'resourcesuggested_link' => 'Suggested Link',
        'resourcetype' => 'Resource Type',
        'resourcedocument' => 'Open Document',
        'resourcevideo' => 'Open Video',
        'suggestedby'=>'Suggested By',
      ),
      'view' => 'View',
      'download' => 'Download',
    ),
       'submitsuggestion' => 
    array (
      'title' => "SUGGESTION FOR REFERRING EXTERNAL RESOURCES",
      'fields' => 
      array (
        'resourcecat' => 'Resource Category',
        'resourcetitle' => 'Resource Title',
        'resourcetitle' => 'Resource Type',
        'suggestedby'=>'Suggested By',
      ),
      'view' => 'View',
      'download' => 'Download',
    ),


    'courserequest' => 
    array (
      'title' => "REQUEST FOR NEW COURSE",
      'fields' => 
      array (
        'email' => 'Email Id *',
        'name'=>'Full Name *',
        'designation_id'=>'Designation *',
        'state'=>'State *',
        'city'=>'City *',
        'phone'=>'Phone *',
        'track_id'=>'Select Track *',
        'category_id'=>'Select Course Category *',
        'subcategory_id'=>'Select CourseSubCategory *',
        'courses_id'=>'Select Course *',

      ),
      'view' => 'View',
      'download' => 'Download',
    ),

    'bundles' => 
    array (
      'title' => 'Bundles',
      'fields' => 
      array (
        'published' => 'Published',
        'featured' => 'Featured',
        'trending' => 'Trending',
        'free' => 'Free',
        'popular' => 'Popular',
        'teachers' => 'Teachers',
        'category' => 'Category',
        'title' => 'Title',
        'slug' => 'Slug',
        'description' => 'Description',
        'price' => 'Price',
        'course_image' => 'Course Image',
        'start_date' => 'Start Date',
        'meta_title' => 'Meta Title',
        'meta_description' => 'Meta Description',
        'meta_keywords' => 'Meta Keywords',
        'sidebar' => 'Add Sidebar',
        'lessons' => 
        array (
          'add' => 'Add Lessons',
          'view' => 'View Lessons',
        ),
        'course' => 'Course',
        'courses' => 'Courses',
        'status' => 'Status',
      ),
      'add_courses' => 'Add Courses',
      'add_teachers' => 'Add Teachers',
      'add_categories' => 'Add Categories',
      'slug_placeholder' => 'Input slug or it will be generated automatically',
      'select_category' => 'Select Category',
      'select_courses' => 'Select Courses',
      'select_teachers' => 'Select Teachers',
      'test' => 'Test',
      'lesson' => 'Lesson',
      'create' => 'Create Bundle',
      'edit' => 'Edit Bundle',
      'view' => 'View Bundles',
      'category' => 'Category',
      'save_timeline' => 'Save timeline',
      'course_timeline' => 'Course timeline',
      'timeline_description' => 'Drag and change sequence of Lessons/Tests for course',
      'listing_note' => 'Only Published Lessons and Tests will be Displayed and Sorted.',
    ),
    'reports' => 
    array (
      'title' => 'Reports',
      'sales_report' => 'Sales Report',
      'students_report' => 'Students Report',
      'bundles' => 'Bundles',
      'courses' => 'Courses',
      'total_earnings' => 'Total Earnings',
      'total_sales' => 'Total Sales',
      'fields' => 
      array (
        'name' => 'Name',
        'orders' => 'Orders',
        'earnings' => 'Earnings',
        'course' => 'Course',
        'user' => 'User',
        'content' => 'Content',
        'time' => 'Time',
        'students' => 'Students',
        'bundle' => 'Bundle',
        'completed' => 'Completed Course',
      ),
    ),
    'sitemap' => 
    array (
      'title' => 'Sitemap',
      'records_per_file' => 'Records Per File',
      'records_note' => 'Number of records per file.',
      'generated' => 'Sitemap generated successfully.',
      'generate' => 'Generate',
      'daily' => 'Daily',
      'weekly' => 'Weekly',
      'monthly' => 'Monthly',
      'sitemap_note' => 'This sitemap tool will generate sitemap for published Course, Bundles and Blog.',
    ),
    'forum_category' => 
    array (
      'title' => 'Forum Categories',
      'create' => 'Create Forum Category',
      'edit' => 'Edit Forum Category',
      'view' => 'View Forum Category',
      'on' => 'On',
      'off' => 'Off',
      'fields' => 
      array (
        'parent_category' => 'Parent Category',
        'category' => 'Category',
        'order' => 'Order',
        'color' => 'Color',
        'status' => 'Status',
      ),
    ),
  ),
  'general' => 
  array (
    'active' => 'Active',
    'inactive' => 'Inactive',
    'yes' => 'Yes',
    'no' => 'No',
    'none' => 'None',
    'back' => 'Back',
    'more' => 'More',
    'buttons' => 
    array (
      'update' => 'Update',
      'cancel' => 'Cancel',
      'save' => 'Save',
    ),
    'toolbar_btn_groups' => 'Toolbar with button groups',
    'create_new' => 'Create New',
    'all' => 'All',
    'trash' => 'Trash',
    'delete' => 'Delete',
    'no_data_available' => 'No data available',
    'edit' => 'Edit',
    'copyright' => 'Copyright',
    'delete_selected' => 'Delete Selected',
    'custom' => 'Custom',
    'actions' => 'Actions',
    'hide' => 'Hide',
    'show' => 'Show',
    'toggle_navigation' => 'Toggle Navigation',
    'sr_no' => 'Sr No.',
    'read_more' => 'Read More',
  ),
  'frontend' => 
  array (
    'auth' => 
    array (
      'login_button' => 'Login',
      'login_box_title' => 'Login',
      'remember_me' => 'Remember Me',
      'register_box_title' => 'Register',
      'register_button' => 'Register',
      'login_with' => 'Login with :social_media',
    ),
    'passwords' => 
    array (
      'reset_password_box_title' => 'Reset Password',
      'send_password_reset_link_button' => 'Send Password Reset Link',
      'expired_password_box_title' => 'Your password has expired.',
      'update_password_button' => 'Update Password',
      'reset_password_button' => 'Reset Password',
      'forgot_password' => 'Forgot Your Password?',
    ),
    'blog' => 
    array (
      'share_this_news' => 'Share this news',
      'related_news' => '<span>Related</span> News',
      'post_comments' => 'Post <span>Comments.</span>',
      'write_a_comment' => 'Write a Comment',
      'add_comment' => 'Add Comment',
      'by' => 'By',
      'title' => 'Blog',
      'search_blog' => 'Search Blog',
      'blog_categories' => 'Blog <span>Categories.</span>',
      'popular_tags' => 'Popular <span>Tags.</span>',
      'featured_course' => 'Featured <span>Course.</span>',
      'login_to_post_comment' => 'Login to Post a Comment',
      'no_comments_yet' => 'No comments yet, Be the first to comment.',
    ),
    'cart' => 
    array (
      'payment_status' => 'Payment Status',
      'payment_cards' => 'Credit or Debit Card',
      'name_on_card_placeholder' => 'Enter the name written on your card',
      'no_payment_method' => 'No payment method available at this moment',
      'card_number_placeholder' => 'Enter your card number',
      'cvv' => 'CVV',
      'mm' => 'MM',
      'yy' => 'YY',
      'pay_now' => 'Pay Now',
      'stripe_error_message' => 'Please correct the errors and try again.',
      'paypal' => 'PayPal',
      'pay_securely_paypal' => 'Pay securely with PayPal',
      'offline_payment' => 'Offline Payment',
      'offline_payment_note' => 'In this payment method our executives will contact you and give you instructions regarding payment and course purchase.',
      'request_assistance' => 'Request Assistance',
      'cart' => 'Cart',
      'checkout' => 'Checkout',
      'your_shopping_cart' => 'Your Shopping Cart',
      'complete_your_purchases' => 'Complete<span> Your Purchases.</span>',
      'order_item' => 'Order <span>Item.</span>',
      'course_name' => 'Course Name',
      'course_type' => 'Course Type',
      'starts' => 'Starts',
      'empty_cart' => 'Your cart is empty',
      'order_payment' => 'Order <span>Payment.</span>',
      'name_on_card' => 'Name on Card',
      'card_number' => 'Card Number',
      'expiration_date' => 'Expiration Date',
      'confirmation_note' => 'By confirming this purchase, I agree to the <b>Term of Use, Refund Policy</b> and <b>Privacy Policy</b>',
      'order_detail' => 'Order <span>Detail.</span>',
      'total' => 'Total',
      'your_payment_status' => 'Your <span>Payment Status.</span>',
      'success_message' => 'Congratulations. Enjoy your course',
      'see_more_courses' => 'See More Courses',
      'go_back_to_cart' => 'Go back to Cart',
      'product_name' => 'Product Name',
      'product_type' => 'Product Type',
      'product_added' => 'Product added to cart successfully',
      'try_again' => 'Error! Please Try again.',
      'payment_done' => 'Payment done successfully !',
      'payment_failed' => 'Error! Payment Failed!',
      'offline_request' => 'Request received successfully! check your registered email for further details.',
      'purchase_successful' => 'Congratulations! You\'ve purchased this course.',
      'unknown_error' => 'Unknown error occurred',
      'connection_timeout' => 'Connection Timeout',
      'sub_total' => 'Sub Total',
      'apply' => 'Apply',
      'items' => 'items',
      'item' => 'item',
      'offers' => 'Offers',
      'empty_input' => 'Write coupon code before applying',
      'invalid_coupon' => 'Invalid Coupon!',
      'amount' => 'Amount',
      'total_payable' => 'Total Payable',
      'price' => 'Price',
    ),
    'contact' => 
    array (
      'title' => 'Contact',
      'your_name' => 'Your Name',
      'your_email' => 'Your Email',
      'phone_number' => 'Phone Number',
      'message' => 'Message',
      'box_title' => 'Contact Us',
      'button' => 'Send Information',
      'send_us_a_message' => 'Send Us A<span> Message.</span>',
      'keep_in_touch' => 'Keep<span> In Touch.</span>',
      'send_email' => 'Send Email',
      'send_message_now' => 'Send Message Now',
    ),
    'badges' => 
    array (
      'trending' => 'Trending',
    ),
    'course' => 
    array (
      'ratings' => 'Ratings',
      'stars' => 'Stars',
      'by' => 'By',
      'no_reviews_yet' => 'No reviews yet.',
      'add_to_cart' => 'Add To Cart',
      'buy_note' => 'Only Students Can Buy Course',
      'continue_course' => 'Continue Course',
      'enrolled' => 'Enrolled',
      'chapters' => 'Chapters',
      'category' => 'Category',
      'author' => 'Author',
      'courses' => 'Courses',
      'students' => 'Students',
      'give_test_again' => 'Give Test Again',
      'submit_results' => 'Submit Results',
      'chapter_videos' => 'Chapter Videos',
      'download_files' => 'Download Files',
      'mb' => 'MB',
      'prev' => 'PREV',
      'test' => 'Test',
      'completed' => 'Completed',
      'title' => 'Course',
      'course_details' => '<span>Course Details.</span>',
      'course_detail' => 'Course Details',
      'course_timeline' => 'Course <b>Timeline:</b>',
      'go' => 'Go',
      'course_reviews' => 'Course <span>Reviews:</span>',
      'average_rating' => 'Average Rating',
      'details' => 'Details',
      'add_reviews' => 'Add <span>Reviews.</span>',
      'your_rating' => 'Your Rating',
      'message' => 'Message',
      'add_review_now' => 'Add Review Now',
      'price' => 'Price',
      'added_to_cart' => 'Added To Cart',
      'buy_now' => 'Buy Now',
      'get_now' => 'Get Now',
      'recent_news' => '<span>Recent  </span>News.',
      'view_all_news' => 'View All News',
      'featured_course' => '<span>Featured</span> Course.',
      'sort_by' => '<b>Sort</b> By',
      'popular' => 'Popular',
      'none' => 'None',
      'trending' => 'Trending',
      'featured' => 'Featured',
      'course_name' => 'Course Name',
      'course_type' => 'Course Type',
      'starts' => 'Starts',
      'full_text' => 'FULL TEXT',
      'find_courses' => 'FIND COURSES',
      'your_test_score' => 'Your Test Score',
      'find_your_course' => '<span>Find </span>Your Course.',
      'next' => 'NEXT',
      'progress' => 'Progress',
      'finish_course' => 'Finish Course',
      'certified' => 'You\'re Certified for this course',
      'course' => 'Course',
      'bundles' => 'Bundles',
      'bundle_detail' => 'Bundle Details',
      'bundle_reviews' => 'Bundle <span>Reviews:</span>',
      'available_in_bundles' => 'Also available in Bundles',
      'complete_test' => 'Please Complete Test',
      'looking_for' => 'Looking For?',
      'not_attempted' => 'Not Attempted',
      'explanation' => 'Explanation',
      'find_your_bundle' => '<span>Find</span> your Bundle',
      'select_category' => 'Select Category',
    ),
    'home' => 
    array (
      'title' => 'Home',
      'search_course_placeholder' => 'Type what do you want to learn today?',
      'popular_teachers' => '<span>Popular</span> Teachers',
      'learn_new_skills' => 'Learn new skills',
      'search_course' => 'Search Course',
      'search_courses' => '<span>Search</span> Courses.',
      'students_enrolled' => 'Students Enrolled',
      'online_available_courses' => 'Online Available Courses',
      'teachers' => 'Teachers',
      'our_professionals' => 'Our Professionals',
      'all_teachers' => 'All Teachers',
      'what_they_say_about_us' => 'What they say about us',
    ),
    'layouts' => 
    array (
      'partials' => 
      array (
        'advantages' => 'Advantages',
        'email_address' => 'Email Address',
        'email_registration' => 'Email Us For Free Registration',
        'call_us_registration' => 'Call Us For Free Registration',
        'students' => 'Students',
        'faq' => 'FAQ',
        'more_faqs' => 'More Faqs',
        'search_placeholder' => 'Type what do you want to learn today?',
        'search_our_courses' => 'SEARCH OUR COURSES',
        'browse_featured_course' => 'Browse Our<span> Featured Course.</span>',
        'course_detail' => 'Course detail',
        'contact_us' => 'Contact Us',
        'get_in_touch' => 'Get In Touch',
        'primary' => 'Primary',
        'second' => 'Second',
        'courses_categories' => 'Courses Categories',
        'browse_course_by_category' => 'Browse Courses<span> By Category.</span>',
        'faq_full' => 'Frequently<span> Asked Questions</span>',
        'social_network' => 'Social Network',
        'subscribe_newsletter' => 'Subscribe Newsletter',
        'subscribe_now' => 'Subscribe Now',
        'latest_news_blog' => 'Latest <span>News Blog.</span>',
        'trending_courses' => 'Trending <span>Courses.</span>',
        'popular_courses' => 'Popular <span>Courses.</span>',
        'view_all_news' => 'View All News',
        'view_all_trending_courses' => 'View All Trending Courses',
        'view_all_popular_courses' => 'View All Popular Courses',
        'learn_new_skills' => 'Learn new skills',
        'recent_news' => '<span>Recent  </span>News.',
        'featured_course' => '<span>Featured  </span>Course.',
        'days' => 'Days',
        'hours' => 'Hours',
        'minutes' => 'Minutes',
        'seconds' => 'Seconds',
        'search_courses' => 'Search Courses',
        'sponsors' => 'Sponsors.',
        'students_testimonial' => 'Students <span>Testimonial.</span>',
        'why_choose' => 'Reason Why Choose',
        'certificate_verification' => 'Certificate Verification',
        'offers' => 'Offers',
      ),
    ),
    'modal' => 
    array (
      'new_user_note' => 'New User? Register Here',
      'registration_message' => 'Registration Successful. Please LogIn',
      'my_account' => 'My Account',
      'login_register' => '<a href="#" class="font-weight-bold go-login px-0">LOGIN</a> to our website, or <a href="#" class="font-weight-bold go-register px-0" id="">REGISTER</a>',
      'already_user_note' => 'Already a user? Login Here',
      'login_now' => 'LogIn Now',
      'register_now' => 'Register Now',
    ),
    'search_result' => 
    array (
      'students' => 'Students',
      'blog' => 'Blog',
      'search_blog' => 'Search Blog',
      'sort_by' => '<b>Sort</b> By',
      'popular' => 'Popular',
      'none' => 'None',
      'trending' => 'Trending',
      'featured' => 'Featured',
      'course_name' => 'Course Name',
      'course_type' => 'Course Type',
      'starts' => 'Starts',
      'course_detail' => 'Course Detail',
    ),
    'teacher' => 
    array (
      'send_now' => 'Send Now',
      'students' => 'Students',
      'title' => 'Teachers',
      'courses_by_teacher' => 'Courses <span>By Teacher.</span>',
      'course_detail' => 'Course Detail',
    ),
    'user' => 
    array (
      'passwords' => 
      array (
        'change' => 'Change Password',
      ),
      'profile' => 
      array (
        'avatar' => 'Avatar',
        'created_at' => 'Created At',
        'edit_information' => 'Edit Information',
        'email' => 'E-mail',
        'last_updated' => 'Last Updated',
        'name' => 'Name',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'update_information' => 'Update Information',
      ),
    ),
    'faq' => 
    array (
      'title' => 'Frequently <span>Asked Questions</span>',
      'find' => 'Find <span>Your Questions & Answers.</span>',
      'make_question' => 'Make Question',
      'contact_us' => 'Contact Us',
    ),
    'certificate_verification' => 
    array (
      'title' => 'Certificate Verification',
      'name_on_certificate' => 'Name on Certificate. Ex. John',
      'date_on_certificate' => 'Date on Certificate. Ex. 2018-11-25',
      'verify_now' => 'Verify Now',
      'not_found' => 'No certificate found for given information.',
    ),
    'footer' => 
    array (
      'popular_courses' => 'Popular courses',
      'popular_categories' => 'Popular Categories',
      'featured_courses' => 'Featured Courses',
      'trending_courses' => 'Trending Courses',
      'useful_links' => 'Useful Links',
    ),
    'offers' => 
    array (
      'title' => 'Offers',
      'no_offers' => 'No Offers',
      'unlimited' => 'Unlimited',
      'validity' => 'Validity',
      'minimum_order_amount' => 'Minimum Order Amount',
      'usage' => 'Usage',
      'per_user' => 'Per User',
    ),
  ),
  'lang' => 
  array (
    'en' => 'English',
    'sp' => 'Spanish',
    'fr' => 'French',
    'ar' => 'Arabic',
  ),
  
);
