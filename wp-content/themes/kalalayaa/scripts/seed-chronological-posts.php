<?php
/**
 * Seed Chronological Campus Posts & Media
 *
 * Imports authentic and stock photos into WordPress media library,
 * attaches them as featured images, and creates 10 chronologically distributed
 * posts (2024 - 2026) for each of the 6 Kalalayaa campuses.
 *
 * Run via: ./bin/wp eval-file bin/seed-chronological-posts.php
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo "=== Seeding Chronological Campus Posts & Media ===\n";

// ──────────────────────────────────────────────────────────────
// 1. Collect & Import All Media Files
// ──────────────────────────────────────────────────────────────
$theme_dir = get_template_directory();

$media_sources = array(
	// Authentic theme photos
	'danceclass'             => $theme_dir . '/assets/photos/danceclass.jpg',
	'bharadanatiyam'         => $theme_dir . '/assets/photos/bharadanatiyam.jpg',
	'annualdayfunctions'     => $theme_dir . '/assets/photos/annualdayfunctions.jpg',
	'musicclass'             => $theme_dir . '/assets/photos/musicclass.jpg',
	'vocalmusic'             => $theme_dir . '/assets/photos/vocalmusic.jpg',
	'finearts'               => $theme_dir . '/assets/photos/finearts.jpg',
	'founder-dhipikca'       => $theme_dir . '/assets/photos/founder-dhipikca.jpg',

	// Curated stock photos
	'dance_pose'             => $theme_dir . '/assets/photos/stock/dance_pose.jpg',
	'bharatanatyam_costume'  => $theme_dir . '/assets/photos/stock/bharatanatyam_costume.jpg',
	'temple_heritage'        => $theme_dir . '/assets/photos/stock/temple_heritage.jpg',
	'diyas_festival'         => $theme_dir . '/assets/photos/stock/diyas_festival.jpg',
	'rangoli_art'            => $theme_dir . '/assets/photos/stock/rangoli_art.jpg',
	'veena_strings'          => $theme_dir . '/assets/photos/stock/veena_strings.jpg',
	'classical_percussion'   => $theme_dir . '/assets/photos/stock/classical_percussion.jpg',
	'violin_music'           => $theme_dir . '/assets/photos/stock/violin_music.jpg',
	'vocal_choir'            => $theme_dir . '/assets/photos/stock/vocal_choir.jpg',
	'kindergarten_circle'    => $theme_dir . '/assets/photos/stock/kindergarten_circle.jpg',
	'kids_drawing'           => $theme_dir . '/assets/photos/stock/kids_drawing.jpg',
	'clay_craft'             => $theme_dir . '/assets/photos/stock/clay_craft.jpg',
	'storytelling_puppets'   => $theme_dir . '/assets/photos/stock/storytelling_puppets.jpg',
	'outdoor_play'           => $theme_dir . '/assets/photos/stock/outdoor_play.jpg',
	'splash_water_play'      => $theme_dir . '/assets/photos/stock/splash_water_play.jpg',
	'robotics_lab'           => $theme_dir . '/assets/photos/stock/robotics_lab.jpg',
	'science_experiment'     => $theme_dir . '/assets/photos/stock/science_experiment.jpg',
	'smart_classroom'        => $theme_dir . '/assets/photos/stock/smart_classroom.jpg',
	'coding_kids'            => $theme_dir . '/assets/photos/stock/coding_kids.jpg',
	'sports_running'         => $theme_dir . '/assets/photos/stock/sports_running.jpg',
	'yoga_day'               => $theme_dir . '/assets/photos/stock/yoga_day.jpg',
	'chess_match'            => $theme_dir . '/assets/photos/stock/chess_match.jpg',
	'stage_performance'      => $theme_dir . '/assets/photos/stock/stage_performance.jpg',
);

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$attachment_map = array();

foreach ( $media_sources as $key => $file_path ) {
	if ( ! file_exists( $file_path ) ) {
		echo "Warning: File missing for {$key}: {$file_path}\n";
		continue;
	}

	$filename = basename( $file_path );

	// Check if already imported
	$existing = get_posts( array(
		'post_type'      => 'attachment',
		'meta_key'       => '_kalalayaa_source_key',
		'meta_value'     => $key,
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );

	if ( ! empty( $existing ) ) {
		$attachment_map[ $key ] = $existing[0];
		echo "Found existing attachment for {$key}: ID {$existing[0]}\n";
		continue;
	}

	// Prepare upload
	$wp_upload_dir = wp_upload_dir();
	$target_file   = $wp_upload_dir['path'] . '/' . $filename;
	copy( $file_path, $target_file );

	$filetype = wp_check_filetype( $filename, null );
	$attachment = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $filename,
		'post_mime_type' => $filetype['type'],
		'post_title'     => ucwords( str_replace( array( '-', '_' ), ' ', $key ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	$attach_id = wp_insert_attachment( $attachment, $target_file );
	$attach_data = wp_generate_attachment_metadata( $attach_id, $target_file );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	update_post_meta( $attach_id, '_kalalayaa_source_key', $key );

	$attachment_map[ $key ] = $attach_id;
	echo "Imported attachment for {$key}: ID {$attach_id}\n";
}

echo "Total media attachments ready: " . count( $attachment_map ) . "\n\n";

// ──────────────────────────────────────────────────────────────
// 2. Clear Old Posts (IDs 4 to 15)
// ──────────────────────────────────────────────────────────────
$old_posts = get_posts( array(
	'post_type'      => 'post',
	'posts_per_page' => -1,
	'post_status'    => 'any',
	'fields'         => 'ids',
) );

echo "Cleaning up " . count( $old_posts ) . " existing posts...\n";
foreach ( $old_posts as $old_id ) {
	wp_delete_post( $old_id, true );
}

// ──────────────────────────────────────────────────────────────
// 3. Post Catalog: 10 Chronological Posts per Campus (2024–2026)
// ──────────────────────────────────────────────────────────────
$posts_catalog = array(
	// ─── KK Nagar (Author: 2, Term: kk-nagar) ───
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2024-01-14 10:30:00',
		'title'   => 'Pongal Cultural Fest & Folk Dance Extravaganza at KK Nagar',
		'image'   => 'stage_performance',
		'content' => "Our flagship campus resonated with joy as children, parents, and teachers celebrated Pongal with traditional music, Karagattam folk rhythms, and sweet pongal prepared on campus. The vibrant traditional attire and collective enthusiasm set an inspiring tone for the cultural year ahead.",
	),
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2024-06-22 11:00:00',
		'title'   => 'Vocal & Instrumental Music Workshop: Initiating Young Melodies',
		'image'   => 'musicclass',
		'content' => "Over 60 students from our junior and senior arts batches took part in a specialized weekend workshop on Carnatic vocal foundations and keyboard acoustics. Guided by our senior gurus, students mastered Sarali Varisai with joyful precision.",
	),
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2024-10-12 09:30:00',
		'title'   => 'Vijayadasami Vidyarambham: Welcoming 45 New Toddlers to the Arts',
		'image'   => 'founder-dhipikca',
		'content' => "Under the warm presence of Founder Mrs. Dhipikca Rajasekaran ('Aunty'), 45 little toddlers wrote their first letters in golden paddy grains during our auspicious Vijayadasami ceremony. We welcome each child into the loving Kalalayaa family.",
	),
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2024-11-01 16:00:00',
		'title'   => 'Diwali Light Festival: Children Craft Hand-Painted Clay Diyas',
		'image'   => 'diyas_festival',
		'content' => "The sound of laughter filled our fine arts wing as nursery and arts students molded, baked, and hand-painted earthen diyas. Parents were greeted with a courtyard illuminated by these handcrafted lamps of innocence and peace.",
	),
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2025-02-18 18:00:00',
		'title'   => 'Annual Classical Dance Arangetram: A Mesmerizing Evening of Bharatanatyam',
		'image'   => 'bharadanatiyam',
		'content' => "Ten senior dancers from KK Nagar campus took to the stage for their solo and group Arangetram performances before renowned cultural patrons of Tiruchirappalli. The Varnam choreography showcased years of discipline, poise, and devotion.",
	),
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2025-07-15 10:15:00',
		'title'   => 'Carnatic Vocal & Veena Masterclass with Visiting Vidwans',
		'image'   => 'vocalmusic',
		'content' => "A transformative two-day music immersion brought visiting Vidwans to our acoustic studios. Students explored Bhava, Laya, and the delicate nuances of Veena gamakas, experiencing the profound depth of classical Indian music.",
	),
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2025-11-14 11:00:00',
		'title'   => 'Children’s Day Gala: Phonics Theater & Musical Story Circle',
		'image'   => 'kindergarten_circle',
		'content' => "Children took center stage with musical story enactments, tongue-twister challenges, and colorful costume parades. Every child received a book and a commemorative plant from our admissions counselors.",
	),
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2026-02-28 17:30:00',
		'title'   => 'Annual Day 2026: “Navarasa” Musical Ballet by Our Senior Students',
		'image'   => 'annualdayfunctions',
		'content' => "The grand Annual Day production of 'Navarasa' brought all nine aesthetic expressions to life through synchronized classical dance, live choir, and theatrical drama. A standing ovation from over 400 parents honored the dedication of our students and teachers.",
	),
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2026-07-10 10:00:00',
		'title'   => 'Dance Studio Expansion: Welcoming Little Ghoongroos to the Wing',
		'image'   => 'danceclass',
		'content' => "Our newly soundproofed and air-conditioned dance wing opened its doors to the 2026-27 batch of Bharatanatyam aspirants. Seeing our little ones tie their very first ankle bells was an emotional milestone for the entire faculty.",
	),
	array(
		'campus'  => 'kk-nagar',
		'author'  => 2,
		'date'    => '2026-10-24 16:30:00',
		'title'   => 'Grand Diwali Celebrations: Joy, Rhythm & Traditional Sweets',
		'image'   => 'rangoli_art',
		'content' => "A dazzling rangoli carpet crafted by our students welcomed parents to an evening of musical slokas, joyous group dances, and sweet distribution. A celebration of togetherness and inner light at Kalalayaa KK Nagar.",
	),

	// ─── Srirangam (Author: 3, Term: srirangam) ───
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2024-02-10 09:30:00',
		'title'   => 'Vasant Panchami Saraswati Pooja & Sloka Recitation by Tiny Tots',
		'image'   => 'temple_heritage',
		'content' => "In the serene ambience of Srirangam, our young children dressed in pure white and yellow robes to offer musical prayers to Goddess Saraswati. The melodic chanting of sacred verses echoed through our traditional open-air courtyard.",
	),
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2024-07-20 10:00:00',
		'title'   => 'Guru Purnima Reverence: Honoring Our Traditional Fine Arts Masters',
		'image'   => 'founder-dhipikca',
		'content' => "Students presented handmade garlands, betel leaves, and heartfelt drawings to their teachers in sacred Guru Purnima traditions. Founder Dhipikca Aunty addressed our children on cultivating humility and devotion in learning.",
	),
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2024-10-08 17:00:00',
		'title'   => 'Navratri Golu Display: 9 Divine Nights of Classical Music & Stories',
		'image'   => 'diyas_festival',
		'content' => "Our campus installed a grand 7-tier traditional Golu featuring handcrafted dolls depicting temple legends and freedom heroes. Every evening, different student batches presented vocal concerts and slokas for visiting families.",
	),
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2024-12-18 06:30:00',
		'title'   => 'Margazhi Bhajan Walk: Morning Chanting Along North Chithirai Street',
		'image'   => 'temple_heritage',
		'content' => "An early morning winter procession filled the heritage streets of Srirangam as our students and gurus chanted Thiruppavai verses with small cymbals and mridangam accompaniment. A truly soul-stirring cultural tradition.",
	),
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2025-03-05 15:30:00',
		'title'   => 'Grandmaster Chess Summer League: Young Minds Master the 64 Squares',
		'image'   => 'chess_match',
		'content' => "Thirty junior chess players competed in the Kalalayaa Srirangam Speed Chess Tournament. Our students demonstrated patience, tactical foresight, and sportsmanship under the guidance of our tournament coach.",
	),
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2025-08-15 08:30:00',
		'title'   => 'Independence Day Cultural Pageant & Patriotic Song Ensembles',
		'image'   => 'vocal_choir',
		'content' => "Patriotic fervor swept Srirangam campus with flag hoisting, Bharatanatyam tribute to Vande Mataram, and an ensemble choir singing Tamil patriotic songs composed by Mahakavi Bharatiyar.",
	),
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2025-10-22 11:00:00',
		'title'   => 'Traditional Tanjore Art & Kolam Competition for Parents & Children',
		'image'   => 'rangoli_art',
		'content' => "Mothers and children teamed up to draw intricate rice-flour Kolams and gold-foil Tanjore painting motifs. The event celebrated artistic lineage passed down through generations in temple communities.",
	),
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2026-01-16 09:00:00',
		'title'   => 'Heritage Temple Walk: Students Explore Srirangam’s Sacred Architecture',
		'image'   => 'temple_heritage',
		'content' => "Guided by senior cultural historians, our primary students toured the majestic Raja Gopuram and thousand-pillar halls of Sri Ranganathaswamy Temple, sketching sculptural details and learning ancient stone acoustic techniques.",
	),
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2026-06-25 10:30:00',
		'title'   => 'Veena Strings & Carnatic Rhythms: Weekend Intensive with Guest Vidwan',
		'image'   => 'veena_strings',
		'content' => "Veena virtuoso Shri Raghavan visited our Srirangam campus for an intimate masterclass on ancient plucked strings and Gamaka aesthetics. Students experienced the timeless acoustic resonance of the Saraswati Veena.",
	),
	array(
		'campus'  => 'srirangam',
		'author'  => 3,
		'date'    => '2026-10-18 10:00:00',
		'title'   => 'Vijayadasami Sacred Beginnings: Initiating First Steps in Carnatic Arts',
		'image'   => 'bharatanatyam_costume',
		'content' => "Our autumn Vidyarambham welcomed dozens of enthusiastic young learners into vocal music, Bharatanatyam, and sloka chanting. The sacred thirumangalyam bells rang out in gratitude and blessing.",
	),

	// ─── E-Techno School (Author: 4, Term: e-techno) ───
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2024-03-01 11:00:00',
		'title'   => 'Junior STEM Robotics League: Grade 3 & 4 Students Build Smart Rovers',
		'image'   => 'robotics_lab',
		'content' => "Young innovators assembled sensor-guided obstacle avoiding rovers using modular robotics kits. The practical problem-solving workshop ignited genuine scientific wonder among our future tech leaders.",
	),
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2024-07-28 10:00:00',
		'title'   => 'Science Innovation Expo 2024: Over 50 Interactive Working Models',
		'image'   => 'science_experiment',
		'content' => "From solar-powered irrigation prototypes to hydraulic crane arms, our CBSE students explained complex physics and environmental principles with lucid confidence to visiting parents and judges.",
	),
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2024-11-20 14:00:00',
		'title'   => 'Math Olympiad Regional Qualifiers: 18 Kalalayaa Students Advance',
		'image'   => 'smart_classroom',
		'content' => "Eighteen students from grades 1 to 5 cleared the preliminary round of the South Indian Mathematics Olympiad with flying colors, proving that conceptual rigor and joyful learning go hand in hand.",
	),
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2025-01-25 11:30:00',
		'title'   => 'Coding & Computational Thinking Showcase: Little Programmers Demo Apps',
		'image'   => 'coding_kids',
		'content' => "Using child-friendly block-based coding, students designed interactive educational games and animated stories. Parents tried out the student-created apps on tablet stations in our computer lab.",
	),
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2025-04-12 10:00:00',
		'title'   => '3D Prototyping & Renewable Energy Workshop in Our Maker-Space Lab',
		'image'   => 'robotics_lab',
		'content' => "Students designed miniature wind turbine blades and tested their power output using digital multimeters. Hands-on fabrication demystified engineering concepts and inspired innovative minds.",
	),
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2025-08-30 15:00:00',
		'title'   => 'National Science Day Preparatory Camp: Aerodynamics & Rocketry Fun',
		'image'   => 'science_experiment',
		'content' => "Pressurized water rockets soared into the blue skies above our playground as students investigated launch angles, nozzle pressures, and Newton’s third law of motion through exhilarating outdoor trials.",
	),
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2025-11-28 12:00:00',
		'title'   => 'Inter-School CBSE Quiz Triumph: Kalalayaa E-Techno Clinches 1st Place',
		'image'   => 'smart_classroom',
		'content' => "Our senior quiz team secured top honors at the Trichy District Inter-School Science & General Awareness Quiz, answering rapid-fire rounds on astronomy, ecology, and Tamil Nadu history.",
	),
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2026-02-14 16:00:00',
		'title'   => 'E-Techno Robotics Club Wins Regional CBSE STEM Championship',
		'image'   => 'robotics_lab',
		'content' => "Competing against 24 regional teams, our Grade 4 automated line-following robot completed the obstacle course in record time, earning our team the coveted Innovation Trophy.",
	),
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2026-07-18 10:30:00',
		'title'   => 'Smart Classroom 2.0 Launch: Interactive Digital Labs for Practical Physics',
		'image'   => 'smart_classroom',
		'content' => "Every classroom across E-Techno campus now features high-resolution touch displays, enabling 3D anatomical models, planetary simulations, and virtual laboratory explorations in real time.",
	),
	array(
		'campus'  => 'e-techno',
		'author'  => 4,
		'date'    => '2026-10-10 11:00:00',
		'title'   => 'Young Engineers Hackathon: Sustainable Solutions for Trichy City',
		'image'   => 'coding_kids',
		'content' => "Student teams pitched innovative ideas including smart waste segregation bins, rainwater harvesting sensors, and automated school bus trackers to a panel of engineering faculty.",
	),

	// ─── Cantonment (Author: 5, Term: cantonment) ───
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2024-02-24 10:30:00',
		'title'   => 'World Storytelling Day: Grandmothers Share Tales of Panchatantra',
		'image'   => 'storytelling_puppets',
		'content' => "In an emotional community initiative, neighborhood grandmothers visited our daycare pods to narrate classic Panchatantra and Jataka tales with animated voice modulations and cuddles.",
	),
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2024-06-15 09:30:00',
		'title'   => 'Sensory Play Pods Open for the New Academic Year',
		'image'   => 'kindergarten_circle',
		'content' => "Toddlers explored texture trays, water beads, colorful sand bins, and fragrant herb sachets designed to stimulate cognitive pathways and soothe separation anxiety in first-time schoolers.",
	),
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2024-10-04 11:00:00',
		'title'   => 'Nutrition Week: Cooking Without Fire Fun with Fresh Fruits & Sprouts',
		'image'   => 'outdoor_play',
		'content' => "Children donned miniature chef aprons and rolled sprouted moong chaat, banana smoothies, and cucumber sandwiches, discovering the joy of wholesome nutrition through sensory taste tests.",
	),
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2024-11-22 15:30:00',
		'title'   => 'World Children’s Day Puppet Theater & Dramatic Story Circle',
		'image'   => 'storytelling_puppets',
		'content' => "Our teachers staged a delightful glove-puppet musical about a mischievous elephant who learns kindness in the jungle. Wide-eyed laughter and clapping filled our mini theater wing.",
	),
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2025-03-12 17:00:00',
		'title'   => 'Extended Daycare Evening Hours: Safe, Joyful Care for Working Parents',
		'image'   => 'kindergarten_circle',
		'content' => "Serving corporate and medical professionals in central Trichy, our evening daycare wing provides comforting warm dinners, homework guidance, and calm bedtime storytelling until 7:30 PM.",
	),
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2025-07-08 11:00:00',
		'title'   => 'Little Thespians Drama Workshop: Children Express Emotions Through Mimicry',
		'image'   => 'storytelling_puppets',
		'content' => "Children explored anger, joy, surprise, and empathy through theater games, mask making, and stage expression, building rich emotional intelligence and social adaptability.",
	),
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2025-10-15 10:30:00',
		'title'   => 'Navratri Doll Crafting: Toddlers Shape Colorful Clay Figurines',
		'image'   => 'clay_craft',
		'content' => "Using non-toxic, eco-friendly river clay, our toddlers sculpted little birds, oil lamps, and fruit figurines. Each child took home their dried creation to place on their family Golu steps.",
	),
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2026-01-20 09:30:00',
		'title'   => 'Republic Day Little Patriots March & Tricolor Craft Celebration',
		'image'   => 'outdoor_play',
		'content' => "Decked in saffron, white, and green sashes, toddlers marched enthusiastically across our courtyard, saluting the tricolor flag and singing national melodies with heartwarming innocence.",
	),
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2026-06-12 10:00:00',
		'title'   => 'Speech & Language Stimulation Games: Building Confidence in Early Talkers',
		'image'   => 'kindergarten_circle',
		'content' => "Our lead early childhood speech counselor conducted interactive phoneme games, rhyme echoes, and musical rhythm rounds to nurture clear pronunciation and vocabulary growth in 2-year-olds.",
	),
	array(
		'campus'  => 'cantonment',
		'author'  => 5,
		'date'    => '2026-09-30 11:30:00',
		'title'   => 'Community Helpers Day: Firefighters & Doctors Visit Cantonment Campus',
		'image'   => 'storytelling_puppets',
		'content' => "Children sat inside a real fire response truck, listened to heartbeat sounds through stethoscopes, and greeted community heroes who protect our neighborhoods every day.",
	),

	// ─── Crawford Colony (Author: 6, Term: crawford) ───
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2024-03-18 10:00:00',
		'title'   => 'First Spring Splash Day: Water Play & Bubble Magic at Crawford Nursery',
		'image'   => 'splash_water_play',
		'content' => "Under warm sunshine, our toddlers splashed joyfully in shallow safety pools with colorful floating ducks, water wheels, and giant soapy bubble wands in our enclosed garden.",
	),
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2024-07-12 10:30:00',
		'title'   => 'Sensory Texture Garden Walk: Tiny Hands Touch Herbs, Mud & Pebbles',
		'image'   => 'outdoor_play',
		'content' => "Crawford’s natural texture path invited barefoot walks on smooth river stones, damp cool grass, and warm sand. Children identified sweet tulsi and mint scents with sparkling curiosity.",
	),
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2024-10-18 15:00:00',
		'title'   => 'Parent-Child Clay & Recycled Craft Workshop: Creating Art From Nature',
		'image'   => 'clay_craft',
		'content' => "Parents sat with their little ones on floor mats to transform fallen dry leaves, coconut shells, and clay into delightful animal sculptures and wind chimes for home balconies.",
	),
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2024-12-22 11:00:00',
		'title'   => 'Winter Warmth Celebration: Cozy Rhymes & Motherly Care by the Sandpit',
		'image'   => 'kindergarten_circle',
		'content' => "A serene winter gathering featured hot badam milk, folk lullabies, and sandcastle building challenges. Our ultra-low 1:7 teacher ratio ensured every child felt cherished and seen.",
	),
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2025-04-05 10:00:00',
		'title'   => 'Summer Splash Carnival: Cool Pool Games & Fresh Coconut Water Treats',
		'image'   => 'splash_water_play',
		'content' => "To welcome summer vacation, our garden hosted mist tunnels, mini water slides, and fresh tender coconut water stations. Children splashed away the heat with uninhibited glee.",
	),
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2025-08-08 10:30:00',
		'title'   => 'Little Green Thumbs: Crawford Toddlers Plant Their First Flower Saplings',
		'image'   => 'outdoor_play',
		'content' => "Equipped with tiny watering cans and child-sized trowels, children planted jasmine and marigold saplings in their campus flowerbed, learning gentle stewardship of Mother Earth.",
	),
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2025-11-12 11:00:00',
		'title'   => 'Diwali Diya Painting & Organic Rangoli Making by Nursery Stars',
		'image'   => 'finearts',
		'content' => "Using turmeric powder, beetroot juice, and flower petals, nursery children made eco-friendly, chemical-free Rangoli artwork that brightened the campus entrance porch.",
	),
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2026-03-20 10:30:00',
		'title'   => 'Crawford Kindergarten Graduation Day: Stepping Proudly into Primary School',
		'image'   => 'founder-dhipikca',
		'content' => "Tiny caps and graduation scrolls were bestowed upon our graduating UKG class by Founder Mrs. Dhipikca Rajasekaran. Tears of pride and warm hugs marked a momentous milestone.",
	),
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2026-07-22 10:00:00',
		'title'   => 'First Splash Day of the 2026 Season: Pure Water Wonder at Crawford',
		'image'   => 'splash_water_play',
		'content' => "Laughter echoed once again across our garden lawn as the first splash party of the new academic intake got underway, helping newly enrolled toddlers form fast friendships.",
	),
	array(
		'campus'  => 'crawford',
		'author'  => 6,
		'date'    => '2026-10-15 15:00:00',
		'title'   => 'Finger-Painting & Paper Mache Workshop: Discovering Little Picassos',
		'image'   => 'kids_drawing',
		'content' => "Canvas sheets stretched across our verandah were washed in joyful swirls of finger paints, handprints, and papier-mâché masks in a celebration of messy, brilliant childhood creativity.",
	),

	// ─── Kailash Nagar (Author: 7, Term: kailash-nagar) ───
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2024-02-04 09:30:00',
		'title'   => 'Junior Archery Demonstration: Concentration & Focus from Age 5',
		'image'   => 'sports_running',
		'content' => "Under certified archery trainers, young boys and girls learned steady breath control, stance alignment, and release techniques at our dedicated safety-netted outdoor range.",
	),
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2024-06-21 07:00:00',
		'title'   => 'International Yoga Day: 120 Children Perform Surya Namaskar in Sunrise',
		'image'   => 'yoga_day',
		'content' => "Spread across our vast grassy field along the Kattur highway, students greeted the morning sun with synchronized postures, rhythmic breathing, and quiet meditative focus.",
	),
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2024-09-14 16:00:00',
		'title'   => 'Inter-Campus Athletics Meet: Kailash Nagar Sprinters Shine on the Track',
		'image'   => 'sports_running',
		'content' => "Relay races, hurdle hops, and medicine ball passes kept spirits soaring during our autumn athletic competition. Kailash Nagar’s green brigade bagged top spots in team sprints.",
	),
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2024-12-10 17:30:00',
		'title'   => 'Vocal & Acoustic Keyboard Recital: Melodies from the BHEL Corridor',
		'image'   => 'musicclass',
		'content' => "Students from the BHEL township and Kattur community showcased keyboard melodies and classical Carnatic varnams during our evening twilight music circle.",
	),
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2025-02-26 15:30:00',
		'title'   => 'Annual Sports Day 2025: Celebrating True Teamwork & Healthy Stamina',
		'image'   => 'sports_running',
		'content' => "The torch lighting ceremony inaugurated our grand sports day, featuring gymnastics pyramids, junior archery bullseyes, and spirited tug-of-war rounds between teachers and parents.",
	),
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2025-06-21 07:15:00',
		'title'   => 'Morning Mindfulness & Asanas: Yoga Immersion on Our Expansive Grass Field',
		'image'   => 'yoga_day',
		'content' => "Our physical education coaches led posture alignment exercises that help young minds build emotional resilience, physical flexibility, and calm concentration in daily school life.",
	),
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2025-10-10 10:00:00',
		'title'   => 'Swimming & Aquatic Coordination Camp: Building Confidence in the Water',
		'image'   => 'splash_water_play',
		'content' => "Certified swim coaches trained students in breath control, flutter kicks, and water safety techniques, helping timid swimmers conquer fear and enjoy aquatic coordination.",
	),
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2026-01-28 11:00:00',
		'title'   => 'Junior Archery Squad Qualifies for Tamil Nadu State Championship Trials',
		'image'   => 'sports_running',
		'content' => "Six students from Kailash Nagar’s junior archery team scored bullseyes in the district selection rounds and secured their berth at the Tamil Nadu State Junior Archery Trials.",
	),
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2026-06-30 10:00:00',
		'title'   => 'Athletic Dexterity & Obstacle Course Adventure for Primary Explorers',
		'image'   => 'outdoor_play',
		'content' => "Rope climbs, balance beams, tire runs, and agility ladders tested physical motor skills in a supportive, cheering atmosphere where every participant earned an effort medal.",
	),
	array(
		'campus'  => 'kailash-nagar',
		'author'  => 7,
		'date'    => '2026-10-20 16:00:00',
		'title'   => 'Annual Sports Gala 2026: Trophy Distribution by Founder Dhipikca Mam',
		'image'   => 'founder-dhipikca',
		'content' => "Founder Mrs. Dhipikca Rajasekaran commended our young athletes for their discipline and team spirit, presenting the overall Championship Shield to the Blue House champions.",
	),
);

// ──────────────────────────────────────────────────────────────
// 4. Insert Posts & Assign Taxonomies, Authors, Dates, & Images
// ──────────────────────────────────────────────────────────────
echo "Inserting " . count( $posts_catalog ) . " chronological posts...\n";

$created_count = 0;

foreach ( $posts_catalog as $item ) {
	$post_date = $item['date'];

	$post_data = array(
		'post_title'    => $item['title'],
		'post_content'  => $item['content'],
		'post_status'   => 'publish',
		'post_author'   => $item['author'],
		'post_type'     => 'post',
		'post_date'     => $post_date,
		'post_date_gmt' => get_gmt_from_date( $post_date ),
	);

	$new_id = wp_insert_post( $post_data );

	if ( is_wp_error( $new_id ) ) {
		echo "Failed to create post '{$item['title']}': " . $new_id->get_error_message() . "\n";
		continue;
	}

	// Assign campus taxonomy
	wp_set_object_terms( $new_id, $item['campus'], 'campus', false );

	// Assign featured image
	$img_key = $item['image'];
	if ( isset( $attachment_map[ $img_key ] ) ) {
		set_post_thumbnail( $new_id, $attachment_map[ $img_key ] );
	}

	$created_count++;
	echo "  [{$item['campus']}] ({$post_date}) ID {$new_id} -> '{$item['title']}' (Thumb: {$img_key})\n";
}

echo "\nSuccessfully seeded {$created_count} chronological posts across all 6 campuses!\n";
