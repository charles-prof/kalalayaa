// Kalalayaa Schools & Fine Arts Data Registry
// Unified Multi-Branch Architecture Data Model with Authentic Photo Assets

export const CAMPUSES = [
  {
    id: 'kk-nagar',
    name: 'Kalalayaa KK Nagar',
    subtitle: 'Flagship Early Childhood & Fine Arts Academy',
    badge: 'Flagship & Cultural Hub',
    image: 'assets/photos/danceclass.jpg',
    address: 'Plot 42, Sundar Nagar Main Road, K.K. Nagar, Tiruchirappalli - 620021',
    landmark: 'Near K.K. Nagar Park & Bus Stand',
    phone: '+91 94431 82910',
    counselor: 'Mrs. Jayanthi Subramanian',
    counselorTitle: 'Senior Early Learning & Arts Counselor',
    email: 'kknagar.admissions@kalalayaaschools.com',
    whatsapp: '919443182910',
    accentColor: '#0E2E35', // Deep Teal Brand Flagship
    accentBg: 'rgba(14, 46, 53, 0.08)',
    badgeColor: 'badge-teal',
    capacity: '240 Children',
    studentRatio: '1:8 Care Ratio',
    established: '2016',
    description: 'Our flagship sanctuary where early childhood learning converges with rich cultural arts. Featuring spacious sound-proof music wings, indoor play sanctuaries, and specialized toddler care pods.',
    programs: [
      { name: 'Toddler Playgroup', age: '1.5 - 2.5 Years', desc: 'Gentle separation-free sensory environment with tactile games and music.' },
      { name: 'Pre-KG & Nursery', age: '2.5 - 3.5 Years', desc: 'Montessori-inspired gross motor skill development and early phonics.' },
      { name: 'LKG & UKG Foundations', age: '3.5 - 5.5 Years', desc: 'Holistic school-readiness blending bilingual vocabulary, numeracy, and arts.' },
      { name: 'Kalalayaa Fine Arts Wing', age: '4 - 18 Years', desc: 'Bharatanatyam, Carnatic Vocal, Keyboard, and Drawing with master gurus.' },
      { name: 'Executive Daycare Sanctuary', age: '1.5 - 10 Years', desc: 'Safe after-school haven with warm meals, bedtime story hours, and homework care.' }
    ],
    features: [
      'Soundproof Classical Dance & Carnatic Vocal Studios',
      'Air-Conditioned Anti-Microbial Rubberized Play Zone',
      'Dedicated Phonics & Language Immersion Lab',
      'High-Definition CCTV with Parent App Real-Time Access',
      'Emergency First-Aid Nurse & Pediatric Doctor on Call'
    ],
    stats: {
      students: '380+',
      teachers: '24 Caring Educators',
      parentRating: '4.9 / 5 (160+ Reviews)'
    }
  },
  {
    id: 'srirangam',
    name: 'Kalalayaa Srirangam',
    subtitle: 'Heritage Early Learning & Traditional Arts Sanctuary',
    badge: 'Heritage & Traditional Arts',
    image: 'assets/photos/bharadanatiyam.jpg',
    address: 'Near Ranga Nagar, North Chithirai Street Axis, Srirangam, Tiruchirappalli - 620006',
    landmark: '5 Mins from Sri Ranganathaswamy Temple Tower',
    phone: '+91 94431 82911',
    counselor: 'Mrs. Radhika Raman',
    counselorTitle: 'Head of Admissions & Cultural Program Coordinator',
    email: 'srirangam.admissions@kalalayaaschools.com',
    whatsapp: '919443182911',
    accentColor: '#E0281D', // Torch Crimson Accent
    accentBg: 'rgba(224, 40, 29, 0.08)',
    badgeColor: 'badge-crimson',
    capacity: '180 Children',
    studentRatio: '1:7 Care Ratio',
    established: '2022',
    description: 'Immersed in the serene, spiritual heritage of Srirangam, this campus nurtures respect, mindfulness, traditional sloka chanting, and fine arts alongside modern playgroup milestones.',
    programs: [
      { name: 'Toddler Gurukulam Nest', age: '1.5 - 2.5 Years', desc: 'Nature-infused toddler haven surrounded by natural ventilation and tulsi gardens.' },
      { name: 'Pre-KG Heritage Circle', age: '2.5 - 3.5 Years', desc: 'Joyful exploration through Tamil nursery rhymes, English story-cubes, and rhythmic clapping.' },
      { name: 'Kindergarten Arts Prep', age: '3.5 - 5.5 Years', desc: 'Foundational reading, basic mathematical concepts, and clay sculpting.' },
      { name: 'Srirangam Fine Arts Wing', age: '4 - 16 Years', desc: 'Renowned weekend Bharatanatyam, Carnatic Vocal, Slokas, and Flute workshops.' }
    ],
    features: [
      'Open-Air Courtyard for Natural Play and Sunshine',
      'Specialized Sloka & Rhythmic Mind Gym',
      'Grandmaster Chess & Rubik’s Speedcubing Pods',
      'Eco-Friendly Wooden Toys & Zero-Plastic Play Zone',
      'Dedicated Pick-up and Drop Safe Transit Shuttles'
    ],
    stats: {
      students: '210+',
      teachers: '16 Devoted Teachers',
      parentRating: '4.95 / 5 (98 Reviews)'
    }
  },
  {
    id: 'e-techno',
    name: 'Kalalayaa E-Techno School',
    subtitle: 'Future-Ready CBSE Curriculum & STEM Innovation Hub',
    badge: 'CBSE STEM Innovation',
    image: 'assets/photos/annualdayfunctions.jpg',
    address: 'Trichy Central Learning Hub, Near Cantonment-Thillai Nagar Corridor, Tiruchirappalli - 620001',
    landmark: 'Direct Connectivity from Central Bus Terminal & Junction',
    phone: '+91 94431 82912',
    counselor: 'Mr. Arvind Swaminathan',
    counselorTitle: 'Senior Academic & CBSE Admissions Director',
    email: 'etechno.admissions@kalalayaaschools.com',
    whatsapp: '919443182912',
    accentColor: '#27AF0A', // Grove Green (Tuition/CBSE badge)
    accentBg: 'rgba(39, 175, 10, 0.08)',
    badgeColor: 'badge-green',
    capacity: '450 Students',
    studentRatio: '1:15 Learning Ratio',
    established: '2023',
    description: 'Our premier modern campus bridging academic rigor with practical scientific curiosity. Equipped with modern robotics kits, smart interactive classrooms, and Olympiad mentorship.',
    programs: [
      { name: 'CBSE Primary Grades (1-5)', age: '6 - 10 Years', desc: 'Inquiry-led CBSE syllabus integrating daily laboratory experiments, English fluency, and Vedic Math.' },
      { name: 'CBSE Middle School (6-8)', age: '11 - 14 Years', desc: 'Concept mastery, experiential physics & chemistry, and analytical aptitude testing.' },
      { name: 'Robotics, AI & STEM Academy', age: '7 - 15 Years', desc: 'Hands-on Arduino programming, sensor circuits, competitive robotics, and drone basics.' },
      { name: 'Speedcubing & Mathematical Olympiad', age: '6 - 16 Years', desc: 'Algorithmic memory coaching, national tournament preparation, and Rubik’s record training.' }
    ],
    features: [
      'Maker-Space STEM Innovation & 3D Prototyping Lab',
      'Interactive Smart Boards in Every Classroom',
      'Integrated Science & Mathematical Reasoning Laboratories',
      'Indoor Multi-Sport Arena (Badminton, Table Tennis & Archery)',
      'Digital Coding Station with Python & Scratch Curriculum'
    ],
    stats: {
      students: '420+',
      teachers: '32 Specialized Faculty',
      parentRating: '4.85 / 5 (130+ Reviews)'
    }
  },
  {
    id: 'cantonment',
    name: 'Kalalayaa Cantonment',
    subtitle: 'Urban Early Education & Creative Development Center',
    badge: 'Urban Hub & Extended Care',
    image: 'assets/photos/vocalmusic.jpg',
    address: '8/2 Officer’s Line, Near Head Post Office & Collectorate Road, Cantonment, Tiruchirappalli - 620001',
    landmark: 'Opposite State Bank Officers Enclave',
    phone: '+91 94431 82913',
    counselor: 'Mrs. Deepa Meenakshi',
    counselorTitle: 'Campus Coordinator & Early Childhood Specialist',
    email: 'cantonment.admissions@kalalayaaschools.com',
    whatsapp: '919443182913',
    accentColor: '#1B6B78', // Calm Teal
    accentBg: 'rgba(27, 107, 120, 0.08)',
    badgeColor: 'badge-teal',
    capacity: '190 Children',
    studentRatio: '1:8 Care Ratio',
    established: '2018',
    description: 'Ideally situated in the central heart of Trichy for busy working professionals. Renowned for its comforting daycare pods, speech-language stimulation, and creative dramatics.',
    programs: [
      { name: 'Infant & Toddler Nest', age: '1.5 - 2.5 Years', desc: 'Secure, loving sanctuary with infant cots, sterilizers, and trained maternal caregivers.' },
      { name: 'Pre-KG & Kinder Discovery', age: '2.5 - 4.5 Years', desc: 'Phonics-first curriculum with interactive puppetry and sensory motor tracks.' },
      { name: 'Extended Corporate Daycare', age: '1.5 - 9 Years', desc: 'Extended care till 7:30 PM with nutritious warm meals, supervised homework, and fine arts.' },
      { name: 'Children’s Theater & Public Speaking', age: '4 - 12 Years', desc: 'Confidence building, diction clarity, stage presence, and Tamil & English elocution.' }
    ],
    features: [
      'Extended Evening Hours with Dedicated Evening Nurses',
      'Nutritious Fresh Snack & Meal Preparation Kitchen',
      'Mini Stage Theater with Sound & Costume Props',
      'App-Controlled Fingerprint Entry & Visitor Security Protocol',
      'Central Trichy Accessibility with Dedicated Drop-off Bay'
    ],
    stats: {
      students: '220+',
      teachers: '18 Trained Teachers',
      parentRating: '4.9 / 5 (112 Reviews)'
    }
  },
  {
    id: 'crawford',
    name: 'Kalalayaa Crawford Colony',
    subtitle: 'Nurturing Neighborhood Nursery & Creative Arts Wing',
    badge: 'Cozy Community Campus',
    image: 'assets/photos/finearts.jpg',
    address: 'Near Crawford Railway Colony Main Road, Crawford, Tiruchirappalli - 620012',
    landmark: 'Close to Railway Quarters & Trichy-Madurai Link',
    phone: '+91 94431 82914',
    counselor: 'Mrs. Sujatha Saravanan',
    counselorTitle: 'Lead Early Educator & Admissions Guide',
    email: 'crawford.admissions@kalalayaaschools.com',
    whatsapp: '919443182914',
    accentColor: '#A85229', // Earthy Terracotta
    accentBg: 'rgba(168, 82, 41, 0.08)',
    badgeColor: 'badge-crimson',
    capacity: '150 Children',
    studentRatio: '1:7 Care Ratio',
    established: '2020',
    description: 'A cozy, intimate campus where every child receives individualized motherly attention. Perfect for first-time schoolers transitioning from home to structured social play.',
    programs: [
      { name: 'First-Step Playgroup', age: '1.5 - 2.5 Years', desc: 'Gentle, zero-pressure social play with soft tunnels, tactile sensory balls, and music.' },
      { name: 'Pre-KG & LKG Wonderpod', age: '2.5 - 4.5 Years', desc: 'Alphabet exploration, number rhymes, fine motor tracing, and water play.' },
      { name: 'Keyboard & Melodic Arts', age: '4 - 12 Years', desc: 'Introductory piano, rhythm beats, and finger dexterity exercises.' },
      { name: 'Drawing & Painting Club', age: '4 - 14 Years', desc: 'Color theory, oil pastels, cartoon sketching, and clay modeling.' }
    ],
    features: [
      'Enclosed Green Sandpit & Outdoor Texture Garden',
      'Ultra-Low Teacher-Child Ratio (1:7) for Attentive Care',
      'Weekly Parent Engagement & Milestone Sharing',
      'Safe Splash Pool & Water Play Station',
      'Homely, Noise-Free Residential Colony Setting'
    ],
    stats: {
      students: '165+',
      teachers: '14 Loving Caregivers',
      parentRating: '4.92 / 5 (84 Reviews)'
    }
  },
  {
    id: 'kailash-nagar',
    name: 'Kalalayaa Kailash Nagar',
    subtitle: 'Holistic Early Care & Talent Discovery Campus',
    badge: 'Athletics & Talent Discovery',
    image: 'assets/photos/musicclass.jpg',
    address: 'Kailash Nagar Extension, Near Kattur / BHEL Highway, Tiruchirappalli - 620019',
    landmark: 'Near BHEL Township Gate & Kattur High Road',
    phone: '+91 94431 82915',
    counselor: 'Mrs. Bhavani Kumar',
    counselorTitle: 'Admissions Lead & Athletic Arts Coordinator',
    email: 'kailashnagar.admissions@kalalayaaschools.com',
    whatsapp: '919443182915',
    accentColor: '#5B8C00', // Forest Green
    accentBg: 'rgba(91, 140, 0, 0.08)',
    badgeColor: 'badge-green',
    capacity: '175 Children',
    studentRatio: '1:8 Care Ratio',
    established: '2021',
    description: 'Serving families across Kattur and the BHEL township, this campus specializes in outdoor physical dexterity, junior archery, swimming coordination, and foundational academics.',
    programs: [
      { name: 'Active Toddlers Playgroup', age: '1.5 - 2.5 Years', desc: 'Physical motor agility, balancing beams, colorful ball pools, and nursery tunes.' },
      { name: 'Kindergarten & Phonics', age: '2.5 - 5.5 Years', desc: 'Jolly Phonics reading method, bilingual conversational practice, and basic math.' },
      { name: 'Junior Archery & Mental Focus', age: '5 - 15 Years', desc: 'Traditional and Olympic junior target archery fostering intense stillness and focus.' },
      { name: 'Classical Bharatanatyam & Folk', age: '4 - 16 Years', desc: 'Traditional dance adavus, mudras, rhythm expression, and stage performance.' }
    ],
    features: [
      'Expansive Open Grass Field for Outdoor Sports',
      'Certified Junior Archery Range with Safety Nets',
      'Vocal Music & Acoustic Keyboard Studio',
      'Safe Daily Van Shuttle with Dedicated Female Conductor',
      'Spacious Activity Hall for Parents and Children Events'
    ],
    stats: {
      students: '190+',
      teachers: '15 Dedicated Staff',
      parentRating: '4.88 / 5 (91 Reviews)'
    }
  }
];

export const FINE_ARTS_DISCIPLINES = [
  {
    id: 'bharatanatyam',
    title: 'Classical Bharatanatyam',
    icon: 'sparkles',
    image: 'assets/photos/bharadanatiyam.jpg',
    category: 'Performing Arts',
    ageGroup: 'Ages 4+',
    campuses: ['KK Nagar', 'Srirangam', 'Kailash Nagar', 'Cantonment'],
    desc: 'Rooted in timeless Tamil heritage. Our master gurus guide students through Adavus, Mudras, Bhava, and Abhinaya, building rhythm, discipline, and poise with annual stage showcases.'
  },
  {
    id: 'carnatic',
    title: 'Carnatic Vocal & Slokas',
    icon: 'music',
    image: 'assets/photos/vocalmusic.jpg',
    category: 'Vocal Arts',
    ageGroup: 'Ages 4+',
    campuses: ['KK Nagar', 'Srirangam', 'Kailash Nagar'],
    desc: 'Voice culture, Sarali Varisai, Geethams, and soulful Sanskrit/Tamil devotional slokas. Fosters deep respiratory control, cognitive memory, and cultural reverence.'
  },
  {
    id: 'keyboard',
    title: 'Western & Melodic Keyboard',
    icon: 'volume-2',
    image: 'assets/photos/musicclass.jpg',
    category: 'Instrumental',
    ageGroup: 'Ages 5+',
    campuses: ['KK Nagar', 'Crawford', 'E-Techno', 'Cantonment'],
    desc: 'Structured fingering techniques, staff notation, rhythm tempo, and Trinity College London progressive syllabus preparation in state-of-the-art keyboard pods.'
  },
  {
    id: 'drawing',
    title: 'Drawing, Painting & Clay Craft',
    icon: 'palette',
    image: 'assets/photos/finearts.jpg',
    category: 'Visual Arts',
    ageGroup: 'Ages 3.5+',
    campuses: ['All 6 Campuses'],
    desc: 'Unlocking raw creativity through oil pastels, acrylics, water painting, pencil shading, cartoon sketching, and therapeutic clay modeling.'
  },
  {
    id: 'speedcubing',
    title: 'Rubik’s Cube Speedcubing',
    icon: 'box',
    image: 'assets/photos/danceclass.jpg',
    category: 'Mental Gymnastics',
    ageGroup: 'Ages 5+',
    campuses: ['KK Nagar', 'E-Techno', 'Srirangam'],
    desc: 'Algorithmic pattern recognition from 2x2 up to 5x5, Megaminx, and Pyraminx. Trains spatial intelligence, lightning-fast reflexes, and patience.'
  },
  {
    id: 'chess',
    title: 'Grandmaster Chess Academy',
    icon: 'award',
    image: 'assets/photos/annualdayfunctions.jpg',
    category: 'Strategy & Mind Sports',
    ageGroup: 'Ages 5+',
    campuses: ['All 6 Campuses'],
    desc: 'Opening repertoires, tactical puzzles, endgame maneuvers, and rated tournament sparring. Guided by passionate FIDE-rated coaches.'
  },
  {
    id: 'robotics',
    title: 'Robotics & STEM Innovation',
    icon: 'cpu',
    image: 'assets/photos/annualdayfunctions.jpg',
    category: 'Science & Tech',
    ageGroup: 'Ages 7+',
    campuses: ['Kalalayaa E-Techno School'],
    desc: 'Block-based coding, Arduino microcontrollers, sensory robotics, obstacle-avoiding cars, and 21st-century problem-solving.'
  },
  {
    id: 'archery',
    title: 'Junior Archery & Focus Agility',
    icon: 'target',
    image: 'assets/photos/musicclass.jpg',
    category: 'Sports & Coordination',
    ageGroup: 'Ages 6+',
    campuses: ['Kailash Nagar', 'E-Techno'],
    desc: 'Target precision training fostering breath synchronization, core balance, and unwavering stillness of mind.'
  },
  {
    id: 'theater',
    title: 'Children’s Theater & Speech Diction',
    icon: 'users',
    image: 'assets/photos/danceclass.jpg',
    category: 'Confidence Building',
    ageGroup: 'Ages 4+',
    campuses: ['Cantonment', 'KK Nagar'],
    desc: 'Overcoming stage shyness through creative roleplay, vocal projection, expressive facial cues, and English & Tamil elocution.'
  }
];

export const MOMENTS_GALLERY = [
  {
    id: 'gal-1',
    title: 'Classical Bharatanatyam Gurukulam',
    category: 'Performing Arts',
    caption: 'Students in traditional salangai mastering classical mudras at the Srirangam heritage hall.',
    image: 'assets/photos/bharadanatiyam.jpg',
    tag: 'Srirangam Campus'
  },
  {
    id: 'gal-2',
    title: 'Grand Annual Day Celebrations',
    category: 'Celebration',
    caption: 'Over 600 children, parents, and teachers celebrating student achievements and artistic milestones.',
    image: 'assets/photos/annualdayfunctions.jpg',
    tag: 'All Trichy Campuses'
  },
  {
    id: 'gal-3',
    title: 'Creative Movement & Dance Studio',
    category: 'Early Arts',
    caption: 'Little learners developing rhythm, confidence, and posture in our padded dance sanctuary.',
    image: 'assets/photos/danceclass.jpg',
    tag: 'K.K. Nagar Flagship'
  },
  {
    id: 'gal-4',
    title: 'Visual Arts, Painting & Color Theory',
    category: 'Fine Arts',
    caption: 'Young artists exploring watercolours, acrylics, and clay modelling under master guidance.',
    image: 'assets/photos/finearts.jpg',
    tag: 'Crawford & Kailash Nagar'
  },
  {
    id: 'gal-5',
    title: 'Acoustic Keyboard & Notation Lab',
    category: 'Instrumental',
    caption: 'Students learning Trinity syllabus staff reading and finger tempo on professional keyboards.',
    image: 'assets/photos/musicclass.jpg',
    tag: 'E-Techno & K.K. Nagar'
  },
  {
    id: 'gal-6',
    title: 'Carnatic Vocal & Sacred Slokas',
    category: 'Vocal Arts',
    caption: 'Deep breathing, voice culture, and classical ragas nurturing clarity of speech and cultural pride.',
    image: 'assets/photos/vocalmusic.jpg',
    tag: 'Cantonment & Srirangam'
  }
];

export const INITIAL_INQUIRIES = [
  {
    id: 'INQ-2026-901',
    parentName: 'Mrs. Priyadarshini Sundaram',
    childName: 'Aaradhya S.',
    childAge: '2.5 Years',
    phone: '+91 98424 55102',
    email: 'priya.sundaram@gmail.com',
    campusId: 'srirangam',
    campusName: 'Kalalayaa Srirangam',
    program: 'Toddler Gurukulam Nest & Pre-KG',
    status: 'Contacted',
    date: '2026-11-14 09:30 AM',
    counselor: 'Mrs. Radhika Raman',
    notes: 'Parent visited campus yesterday. Interested in morning toddler session and Carnatic vocal initiation. Follow up scheduled for Monday.'
  },
  {
    id: 'INQ-2026-902',
    parentName: 'Dr. Karthik Narayanan',
    childName: 'Siddharth K.',
    childAge: '8 Years',
    phone: '+91 97908 44211',
    email: 'dr.karthik@apollo.org',
    campusId: 'e-techno',
    campusName: 'Kalalayaa E-Techno School',
    program: 'CBSE Grade 3 + Robotics & AI Lab',
    status: 'New',
    date: '2026-11-14 11:15 AM',
    counselor: 'Mr. Arvind Swaminathan',
    notes: 'Transferring from Chennai to Trichy. Seeking interactive science labs and bus transport from Thillai Nagar.'
  },
  {
    id: 'INQ-2026-903',
    parentName: 'Mrs. Anitha Balaji',
    childName: 'Diya Balaji',
    childAge: '4 Years',
    phone: '+91 94433 77890',
    email: 'anitha.balaji@tcs.com',
    campusId: 'cantonment',
    campusName: 'Kalalayaa Cantonment',
    program: 'LKG + Extended Corporate Daycare',
    status: 'Enrolled',
    date: '2026-11-13 04:45 PM',
    counselor: 'Mrs. Deepa Meenakshi',
    notes: 'Mother works at Collectorate IT corridor. Daycare required until 7 PM. Enrollment fee paid; uniform and kit collected.'
  },
  {
    id: 'INQ-2026-904',
    parentName: 'Mr. Vigneshwaran R.',
    childName: 'Pranav V.',
    childAge: '5 Years',
    phone: '+91 96291 33418',
    email: 'vignesh.r@gmail.com',
    campusId: 'kk-nagar',
    campusName: 'Kalalayaa KK Nagar',
    program: 'UKG Foundations + Rubik’s Speedcubing',
    status: 'New',
    date: '2026-11-14 01:20 PM',
    counselor: 'Mrs. Jayanthi Subramanian',
    notes: 'Child shows exceptional curiosity in 3x3 cube puzzles. Requesting counseling session with Mrs. Dhipikca Aunty.'
  },
  {
    id: 'INQ-2026-905',
    parentName: 'Mrs. Hemalatha Murugan',
    childName: 'Kavya M.',
    childAge: '3 Years',
    phone: '+91 98430 19283',
    email: 'hema.murugan@outlook.com',
    campusId: 'crawford',
    campusName: 'Kalalayaa Crawford Colony',
    program: 'First-Step Playgroup & Drawing Club',
    status: 'Contacted',
    date: '2026-11-12 10:00 AM',
    counselor: 'Mrs. Sujatha Saravanan',
    notes: 'Very gentle child, needs caring transition from home. Mother expressed heartfelt gratitude for Crawford campus warmth.'
  }
];

export const PARENT_TESTIMONIALS = [
  {
    parent: 'Dr. Revathi Mohan',
    child: 'Mother of Tanvi (UKG, Srirangam Campus)',
    rating: 5,
    text: 'When we moved to Srirangam, my biggest worry was finding a school where my daughter felt as safe and loved as she does at home. Mrs. Dhipikca Aunty and her teachers don’t just teach; they wrap every child in genuine maternal warmth. Tanvi now sings slokas joyfully and eagerly waits for Monday mornings!',
    verified: 'Verified Srirangam Parent'
  },
  {
    parent: 'Mr. Saravanan Venkatesh',
    child: 'Father of Harish (Grade 5, E-Techno School)',
    rating: 5,
    text: 'Kalalayaa E-Techno is truly unlike any traditional school in Trichy. The robotics lab and experiential science sessions have transformed Harish’s confidence. He built his first automated obstacle car last month! Truly the right balance of modern STEM and ethical values.',
    verified: 'Verified E-Techno Parent'
  },
  {
    parent: 'Mrs. Meenakshi Sundaram',
    child: 'Mother of Sai (Daycare & Pre-KG, Cantonment Campus)',
    rating: 5,
    text: 'As two working IT parents in Cantonment, the extended daycare sanctuary has been a true blessing. Knowing Sai is eating warm, wholesome food and practicing arts under watchful, loving eyes gives us absolute peace of mind during our workdays.',
    verified: 'Verified Cantonment Parent'
  }
];
