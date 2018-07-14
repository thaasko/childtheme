<?php 

add_action( 'wp_enqueue_scripts', 'workscout_enqueue_styles' );
function workscout_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css',array('workscout-base','workscout-responsive','workscout-font-awesome') );
}
 
function remove_parent_theme_features() { 	
}
add_action( 'after_setup_theme', 'remove_parent_theme_features', 10 );

// Enable frontend editor
function vc_remove_frontend_links() {
    vc_disable_frontend(); // this will disable frontend editor
}
add_action( 'vc_after_init', 'vc_remove_frontend_links' );

// Allow svg images
function add_file_types_to_uploads($file_types){
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
    return $file_types;
    }
add_action('upload_mimes', 'add_file_types_to_uploads');


// Edit fields from resume submission fields 
// Add your own function to filter the fields
add_filter( 'submit_resume_form_fields', 'custom_submit_resume_form_fields' );

// This is your function which takes the fields, modifies them, and returns them
function custom_submit_resume_form_fields( $fields ) {

    // Here we target one of the job fields (candidate name) and change it's label
    $fields['resume_fields']['candidate_name']['label'] = "Naam";
    $fields['resume_fields']['candidate_name']['placeholder'] = "Je volledige naam";

    $fields['resume_fields']['candidate_email']['label'] = "E-mailadres";
    $fields['resume_fields']['candidate_email']['placeholder'] = "naam@mail.com";

    $fields['resume_fields']['candidate_location']['label'] = "Woonplaats";
    $fields['resume_fields']['candidate_location']['placeholder'] = "bijv. Amsterdam of Nijmegen";

    $fields['resume_fields']['candidate_title']['label'] = "Functie omschrijving";
    $fields['resume_fields']['candidate_title']['placeholder'] = "bijv. Masterstudent Corporate Law";
    $fields['resume_fields']['candidate_title']['priority'] = "4.1";
    
    $fields['resume_fields']['candidate_photo']['label'] = "Profielfoto";

    $fields['resume_fields']['resume_content']['label'] = "Samenvatting";
    $fields['resume_fields']['resume_content']['required'] = false;

    // Changes to add link
    $fields['resume_fields']['links']['label'] = "Link naar je LinkedIn profiel";
    $fields['resume_fields']['links']['required'] = false;
    $fields['resume_fields']['links']['description'] = '';
    $fields['resume_fields']['links']['fields']['name']['label'] = "Naam link";
    $fields['resume_fields']['links']['fields']['name']['placeholder'] = "Linkedin";
    $fields['resume_fields']['links']['fields']['url']['label'] = "URL link";
    $fields['resume_fields']['links']['fields']['url']['placeholder'] = "https://nl.linkedin.com/in/naam";

    // Changes to education
    $fields['resume_fields']['candidate_education']['label'] = "Opleiding";
    $fields['resume_fields']['candidate_education']['fields']['location']['label'] = "Onderwijsinstelling";
    $fields['resume_fields']['candidate_education']['fields']['location']['placeholder'] = "bijv. Universiteit van Amsterdam";
    $fields['resume_fields']['candidate_education']['fields']['qualification']['label'] = "Graad";
    $fields['resume_fields']['candidate_education']['fields']['qualification']['placeholder'] = "bijv. Bachelor of Laws (LL.B)";
    $fields['resume_fields']['candidate_education']['fields']['date']['label'] = "Start en einddatum";
    $fields['resume_fields']['candidate_education']['fields']['date']['placeholder'] = "bijv. Sep. 2012 - Jul. 2016";
    $fields['resume_fields']['candidate_education']['fields']['notes']['label'] = "Beschrijving";

    $fields['resume_fields']['candidate_education']['required'] = true;
    
    $fields['resume_fields']['candidate_experience']['label'] = "Werkervaring";

    $fields['resume_fields']['resume_file']['label'] = "Curriculum Vitae";
    $fields['resume_fields']['resume_file']['description'] = "Upload optioneel je cv voor bedrijven om te bekijken. Max. bestandsgrootte: 300 MB.";	

    // And return the modified fields
    return $fields;
}


// Remove fields from resume submission fields 
add_filter( 'submit_resume_form_fields', 'remove_submit_resume_form_fields' );

function remove_submit_resume_form_fields( $fields ) {

	// Unset any of the fields you'd like to remove - copy and repeat as needed
    unset( $fields['resume_fields']['candidate_video'] );
    unset( $fields['resume_fields']['resume_skills'] );

	// And return the modified fields
	return $fields;
}


// Add additional fields to resume submission fields 
// Add resume submission fields to admin
add_filter( 'resume_manager_resume_fields', 'wpjms_admin_resume_form_fields' );
function wpjms_admin_resume_form_fields( $fields ) {
	
    // Geboortedatum
    $fields['_birthdate'] = array(
	    'label' 		=> __( 'Geboortedatum', 'job_manager' ),
	    'type' 			=> 'text',
	    'placeholder' 	=> __( 'Geboortedatum', 'job_manager' ),
	    'description'	=> '',
	    'priority'      => 3.1
    );

    // Education, work experience, extracurricular activities need to be added

    //Cijferlijst middelbareschool
    $fields['_gradelist_secschool'] = array(
	    'label' 		=> __( 'Cijferlijst middelbare school', 'job_manager' ),
	    'type' 			=> 'file',
	    'placeholder' 	=> __( 'Cijferlijst middelbare school', 'job_manager' ),
	    'description'	=> '',
	    'priority'      => 14.1
    );

    // Cijferlijst bachelor
    $fields['_gradelist_bachelor'] = array(
	    'label' 		=> __( 'Cijferlijst bachelor', 'job_manager' ),
	    'type' 			=> 'file',
	    'placeholder' 	=> __( 'Cijferlijst bachelor', 'job_manager' ),
	    'description'	=> '',
	    'priority'      => 14.2
    );    
    
    // Cijferlijst master
    $fields['_gradelist_master'] = array(
	    'label' 		=> __( 'Cijferlijst master', 'job_manager' ),
	    'type' 			=> 'file',
	    'placeholder' 	=> __( 'Cijferlijst master', 'job_manager' ),
	    'description'	=> '',
	    'priority'      => 14.3
    );

    //Aanvullende informatie
    $fields['_file_additional'] = array(
	    'label' 		=> __( 'Aanvullende informatie', 'job_manager' ),
	    'type' 			=> 'file',
	    'placeholder' 	=> __( 'Aanvullende informatie', 'job_manager' ),
	    'description'	=> '',
	    'priority'      => 14.4
    );
    
	return $fields;
}


// Add resume submission fields to frontend
add_filter( 'submit_resume_form_fields', 'wpjms_frontend_resume_form_fields' );
function wpjms_frontend_resume_form_fields( $fields ) {
	
    //Geboortedatum
    $fields['resume_fields']['birthdate'] = array(
	    'label' => __( 'Geboortedatum', 'job_manager' ),
	    'type' => 'text',
	    'required' => true,
	    'placeholder' => '1 januari 1990',
	    'priority' => 3.1
    );
    
    // Education
    $fields['resume_fields']['candidate_education']['fields'] = array (
		'location' => array(
            'label'       => __( 'Onderwijsinstelling', 'wp-job-manager-resumes' ),
            'type'        => 'text',
            'required'    => true,
            'placeholder' => 'bijv. Erasmus School of Law',
            'priority'    => 1
        ),
        
        'qualification' => array(
            'label'       => __( 'Graad', 'wp-job-manager-resumes' ),
            'type'        => 'text',
            'required'    => true,
            'placeholder' => 'bijv. Bachelor of Laws (LL.B)',
            'priority'    => 2
        ),
        
        'course' => array(
				'label'       => __( 'Studierichting', 'wp-job-manager-resumes' ),
				'type'        => 'text',
				'required'    => true,
				'placeholder' => 'bijv. Rechtsgeleerdheid',
				'priority'    => 3
        ),

        'average' => array(
            'label'       => __( 'Gemiddelde cijfer', 'wp-job-manager-resumes' ),
            'type'        => 'text',
            'required'    => false,
            'placeholder' => 'bijv. 7.3',
            'priority'    => 4
        ),
    
        'date' => array(
				'label'       => __( 'Start en einddatum', 'wp-job-manager-resumes' ),
				'type'        => 'text',
				'required'    => true,
				'placeholder' => 'bijv. 09/2012 - 06/2016',
				'priority'    => 5
        )
    );

    // Work experience
    $fields['resume_fields']['candidate_experience']['fields'] = array (
		'employer' => array(
            'label'       => __( 'Werkgever', 'wp-job-manager-resumes' ),
            'type'        => 'text',
            'required'    => true,
            'placeholder' => 'bijv. Advocatenbureau',
            'priority'    => 1
        ),
        
        'job_title' => array(
            'label'       => __( 'Functie titel', 'wp-job-manager-resumes' ),
            'type'        => 'text',
            'required'    => true,
            'placeholder' => 'bijv. Juridisch medewerker',
            'priority'    => 2
        ),
        
        'date' => array(
				'label'       => __( 'Start en einddatum', 'wp-job-manager-resumes' ),
				'type'        => 'text',
				'required'    => true,
				'placeholder' => 'bijv. 01/2015 - 01/2016',
				'priority'    => 3
        ),

        'notes' => array(
            'label'       => __( 'Beschrijving', 'wp-job-manager-resumes' ),
            'type'        => 'textarea',
            'required'    => false,
            'placeholder' => 'Omschrijf je werkzaamheden en/of verantwoordelijkheden.',
            'priority'    => 4
        )
    );
    
    // Extracurricular activities
    $fields['resume_fields']['activities'] = array (
		'label'		  => __( 'Nevenactiviteiten', 'wp-job-manager-resumes' ),
		'type'        => 'links',
		'required'    => false,
		'placeholder' => 'Voeg toe',
		'description' => __( '', 'wp-job-manager-resumes' ),
		'priority'    => 12.1,
		'fields'      => array(
			'function' => array(
				'label'       => __( 'Functie', 'wp-job-manager-resumes' ),
				'type'        => 'text',
				'required'    => true,
				'placeholder' => 'bijv. Penningmeester of voorzitter',
				'priority'    => 1
			),
			'organisation' => array(
				'label'       => __( 'Organisatie', 'wp-job-manager-resumes' ),
				'type'        => 'text',
				'required'    => true,
				'placeholder' => 'Naam van organisatie',
				'priority'    => 2
            ),
            'date' => array(
				'label'       => __( 'Start en einddatum', 'wp-job-manager-resumes' ),
				'type'        => 'text',
				'required'    => true,
				'placeholder' => 'bijv. 09/2015 - 06/2016',
				'priority'    => 3
            ),
            'description' => array(
				'label'       => __( 'Omschrijving', 'wp-job-manager-resumes' ),
				'type'        => 'textarea',
				'required'    => false,
				'placeholder' => 'Omschrijf je werkzaamheden en/of verantwoordelijkheden.',
				'priority'    => 4
			)
		)
    );
    
    // Cijferlijst middelbare school
    $fields['resume_fields']['gradelist_secschool'] = array(
	    'label' => __( 'Cijferlijst middelbare school', 'job_manager' ),
	    'type' => 'file',
	    'required' => true,
	    'placeholder' => '',
	    'priority' => 14.1
    );
    
    // Cijferlijst bachelor
    $fields['resume_fields']['gradelist_bachelor'] = array(
	    'label' => __( 'Cijferlijst bachelor', 'job_manager' ),
	    'type' => 'file',
	    'required' => true,
	    'placeholder' => '',
	    'priority' => 14.2
    );

    // Cijferlijst master
    $fields['resume_fields']['gradelist_master'] = array(
	    'label' => __( 'Cijferlijst master', 'job_manager' ),
	    'type' => 'file',
	    'required' => false,
	    'placeholder' => '',
	    'priority' => 14.3
    );

    // Aanvullende informatie
    $fields['resume_fields']['file_additional'] = array(
	    'label' => __( 'Aanvullende informatie', 'job_manager' ),
	    'type' => 'file',
	    'required' => false,
	    'placeholder' => '',
	    'priority' => 14.4
    );

	return $fields;	
}

// CHANGE JOB SUBMISSION FIELDS
// Edit fields
add_filter( 'submit_job_form_fields', 'custom_submit_job_form_fields' );

function custom_submit_job_form_fields( $fields ) {

    $fields['job']['job_title']['label'] = "Job titel"; // Job title
    $fields['job']['job_deadline']['label'] = "Deadline"; // Job deadline
    $fields['job']['job_deadline']['description'] = "Deadline voor solliciterende kandidaten";

    $fields['job']['job_location']['label'] = "Locatie";
    $fields['job']['job_location']['priority'] = 5; // Job title
    $fields['job']['job_location']['description'] = "Vul de hoofdlocatie in of laat dit leeg wanneer deze baan geen vaste locatie heeft."; 

    $fields['job']['job_category']['label'] = "Job categorie"; // Job deadline

    $fields['job']['job_tags']['label'] = "Job tags"; // Job deadline
    $fields['job']['job_tags']['placeholder'] = "Kies de relevante tags";
    $fields['job']['job_tags']['description'] = "Jobs tags beschrijven de verschillende rechtsgebieden).";

    return $fields;
}

// Remove fields
add_filter( 'submit_job_form_fields', 'remove_submit_job_form_fields' );

function remove_submit_job_form_fields( $fields ) {

    unset( $fields['company']['company_twitter'] ); // Remove Twitter field

	return $fields;
}






?>