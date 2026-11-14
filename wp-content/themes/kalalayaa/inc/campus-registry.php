<?php
/**
 * Declarative Campus Registry
 *
 * Single source of truth for all 6 Kalalayaa campuses in Tiruchirappalli.
 * Supports the flat ₹8,000 future expansion SLA: adding Branch #7 requires
 * only appending a single record here.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns all registered campuses.
 *
 * @return array<string, array>
 */
function kalalayaa_get_campus_registry() {
	return array(
		'kk-nagar'      => array(
			'id'              => 'kk-nagar',
			'name'            => 'Kalalayaa KK Nagar',
			'subtitle'        => 'Flagship Early Childhood & Fine Arts Academy',
			'badge'           => 'Flagship & Cultural Hub',
			'image'           => get_theme_file_uri( 'assets/photos/danceclass.jpg' ),
			'address'         => 'Plot 42, Sundar Nagar Main Road, K.K. Nagar, Tiruchirappalli - 620021',
			'landmark'        => 'Near K.K. Nagar Park & Bus Stand',
			'phone'           => '+91 94431 82910',
			'counselor'       => 'Mrs. Jayanthi Subramanian',
			'counselor_title' => 'Senior Early Learning & Arts Counselor',
			'email'           => 'kknagar.admissions@kalalayaaschools.com',
			'whatsapp'        => '919443182910',
			'accent_color'    => '#0E2E35',
			'accent_bg'       => 'rgba(14, 46, 53, 0.08)',
			'theme_class'     => 'theme-kk-nagar',
			'capacity'        => '240 Children',
			'care_ratio'      => '1:8 Care Ratio',
			'established'     => '2016',
			'description'     => 'Our flagship sanctuary where early childhood learning converges with rich cultural arts. Featuring spacious sound-proof music wings, indoor play sanctuaries, and specialized toddler care pods.',
			'features'        => array(
				'Soundproof Classical Dance & Carnatic Vocal Studios',
				'Air-Conditioned Anti-Microbial Rubberized Play Zone',
				'Dedicated Phonics & Language Immersion Lab',
				'High-Definition CCTV with Parent App Real-Time Access',
			),
		),
		'srirangam'     => array(
			'id'              => 'srirangam',
			'name'            => 'Kalalayaa Srirangam',
			'subtitle'        => 'Heritage Early Learning & Traditional Arts Sanctuary',
			'badge'           => 'Heritage & Traditional Arts',
			'image'           => get_theme_file_uri( 'assets/photos/bharadanatiyam.jpg' ),
			'address'         => 'Near Ranga Nagar, North Chithirai Street Axis, Srirangam, Tiruchirappalli - 620006',
			'landmark'        => '5 Mins from Sri Ranganathaswamy Temple Tower',
			'phone'           => '+91 94431 82911',
			'counselor'       => 'Mrs. Radhika Raman',
			'counselor_title' => 'Head of Admissions & Cultural Program Coordinator',
			'email'           => 'srirangam.admissions@kalalayaaschools.com',
			'whatsapp'        => '919443182911',
			'accent_color'    => '#E0281D',
			'accent_bg'       => 'rgba(224, 40, 29, 0.08)',
			'theme_class'     => 'theme-srirangam',
			'capacity'        => '180 Children',
			'care_ratio'      => '1:7 Care Ratio',
			'established'     => '2022',
			'description'     => 'Immersed in the serene, spiritual heritage of Srirangam, this campus nurtures respect, mindfulness, traditional sloka chanting, and fine arts alongside modern playgroup milestones.',
			'features'        => array(
				'Open-Air Courtyard for Natural Play and Sunshine',
				'Specialized Sloka & Rhythmic Mind Gym',
				'Grandmaster Chess & Rubik’s Speedcubing Pods',
				'Eco-Friendly Wooden Toys & Zero-Plastic Play Zone',
			),
		),
		'e-techno'      => array(
			'id'              => 'e-techno',
			'name'            => 'Kalalayaa E-Techno School',
			'subtitle'        => 'Future-Ready CBSE Curriculum & STEM Innovation Hub',
			'badge'           => 'CBSE STEM Innovation',
			'image'           => get_theme_file_uri( 'assets/photos/annualdayfunctions.jpg' ),
			'address'         => 'Trichy Central Learning Hub, Near Cantonment-Thillai Nagar Corridor, Tiruchirappalli - 620001',
			'landmark'        => 'Direct Connectivity from Central Bus Terminal & Junction',
			'phone'           => '+91 94431 82912',
			'counselor'       => 'Mr. Arvind Swaminathan',
			'counselor_title' => 'Senior Academic & CBSE Admissions Director',
			'email'           => 'etechno.admissions@kalalayaaschools.com',
			'whatsapp'        => '919443182912',
			'accent_color'    => '#27AF0A',
			'accent_bg'       => 'rgba(39, 175, 10, 0.08)',
			'theme_class'     => 'theme-e-techno',
			'capacity'        => '450 Students',
			'care_ratio'      => '1:15 Learning Ratio',
			'established'     => '2023',
			'description'     => 'Our premier modern campus bridging academic rigor with practical scientific curiosity. Equipped with modern robotics kits, smart interactive classrooms, and Olympiad mentorship.',
			'features'        => array(
				'Maker-Space STEM Innovation & 3D Prototyping Lab',
				'Interactive Smart Boards in Every Classroom',
				'Integrated Science & Mathematical Reasoning Laboratories',
				'Indoor Multi-Sport Arena (Badminton, Table Tennis & Archery)',
			),
		),
		'cantonment'    => array(
			'id'              => 'cantonment',
			'name'            => 'Kalalayaa Cantonment',
			'subtitle'        => 'Urban Early Education & Creative Development Center',
			'badge'           => 'Urban Hub & Extended Care',
			'image'           => get_theme_file_uri( 'assets/photos/vocalmusic.jpg' ),
			'address'         => '8/2 Officer’s Line, Near Head Post Office & Collectorate Road, Cantonment, Tiruchirappalli - 620001',
			'landmark'        => 'Opposite State Bank Officers Enclave',
			'phone'           => '+91 94431 82913',
			'counselor'       => 'Mrs. Deepa Meenakshi',
			'counselor_title' => 'Campus Coordinator & Early Childhood Specialist',
			'email'           => 'cantonment.admissions@kalalayaaschools.com',
			'whatsapp'        => '919443182913',
			'accent_color'    => '#1B6B78',
			'accent_bg'       => 'rgba(27, 107, 120, 0.08)',
			'theme_class'     => 'theme-cantonment',
			'capacity'        => '190 Children',
			'care_ratio'      => '1:8 Care Ratio',
			'established'     => '2018',
			'description'     => 'Ideally situated in the central heart of Trichy for busy working professionals. Renowned for its comforting daycare pods, speech-language stimulation, and creative dramatics.',
			'features'        => array(
				'Extended Evening Hours with Dedicated Evening Nurses',
				'Nutritious Fresh Snack & Meal Preparation Kitchen',
				'Mini Stage Theater with Sound & Costume Props',
				'App-Controlled Fingerprint Entry & Visitor Security Protocol',
			),
		),
		'crawford'      => array(
			'id'              => 'crawford',
			'name'            => 'Kalalayaa Crawford Colony',
			'subtitle'        => 'Nurturing Neighborhood Nursery & Creative Arts Wing',
			'badge'           => 'Cozy Community Campus',
			'image'           => get_theme_file_uri( 'assets/photos/finearts.jpg' ),
			'address'         => 'Near Crawford Railway Colony Main Road, Crawford, Tiruchirappalli - 620012',
			'landmark'        => 'Close to Railway Quarters & Trichy-Madurai Link',
			'phone'           => '+91 94431 82914',
			'counselor'       => 'Mrs. Sujatha Saravanan',
			'counselor_title' => 'Lead Early Educator & Admissions Guide',
			'email'           => 'crawford.admissions@kalalayaaschools.com',
			'whatsapp'        => '919443182914',
			'accent_color'    => '#A85229',
			'accent_bg'       => 'rgba(168, 82, 41, 0.08)',
			'theme_class'     => 'theme-crawford',
			'capacity'        => '150 Children',
			'care_ratio'      => '1:7 Care Ratio',
			'established'     => '2020',
			'description'     => 'A cozy, intimate campus where every child receives individualized motherly attention. Perfect for first-time schoolers transitioning from home to structured social play.',
			'features'        => array(
				'Enclosed Green Sandpit & Outdoor Texture Garden',
				'Ultra-Low Teacher-Child Ratio (1:7) for Attentive Care',
				'Weekly Parent Engagement & Milestone Sharing',
				'Safe Splash Pool & Water Play Station',
			),
		),
		'kailash-nagar' => array(
			'id'              => 'kailash-nagar',
			'name'            => 'Kalalayaa Kailash Nagar',
			'subtitle'        => 'Holistic Early Care & Talent Discovery Campus',
			'badge'           => 'Athletics & Talent Discovery',
			'image'           => get_theme_file_uri( 'assets/photos/musicclass.jpg' ),
			'address'         => 'Kailash Nagar Extension, Near Kattur / BHEL Highway, Tiruchirappalli - 620019',
			'landmark'        => 'Near BHEL Township Gate & Kattur High Road',
			'phone'           => '+91 94431 82915',
			'counselor'       => 'Mrs. Bhavani Kumar',
			'counselor_title' => 'Admissions Lead & Athletic Arts Coordinator',
			'email'           => 'kailashnagar.admissions@kalalayaaschools.com',
			'whatsapp'        => '919443182915',
			'accent_color'    => '#5B8C00',
			'accent_bg'       => 'rgba(91, 140, 0, 0.08)',
			'theme_class'     => 'theme-kailash-nagar',
			'capacity'        => '175 Children',
			'care_ratio'      => '1:8 Care Ratio',
			'established'     => '2021',
			'description'     => 'Serving families across Kattur and the BHEL township, this campus specializes in outdoor physical dexterity, junior archery, swimming coordination, and foundational academics.',
			'features'        => array(
				'Expansive Open Grass Field for Outdoor Sports',
				'Certified Junior Archery Range with Safety Nets',
				'Vocal Music & Acoustic Keyboard Studio',
				'Safe Daily Van Shuttle with Dedicated Female Conductor',
			),
		),
	);
}

/**
 * Get data for a single campus by ID.
 *
 * @param string $campus_id
 * @return array|null
 */
function kalalayaa_get_campus( $campus_id ) {
	$registry = kalalayaa_get_campus_registry();
	return isset( $registry[ $campus_id ] ) ? $registry[ $campus_id ] : null;
}
