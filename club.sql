create Database club;
use club;
CREATE TABLE users(
    roll BIGINT PRIMARY KEY,
    name VARCHAR(255),
    dept VARCHAR(255),
    batch VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255)
);

create table admin(
    email VARCHAR(255),
    password VARCHAR(255),
    PRIMARY KEY(email)
);
insert into admin values('admin@gmail.com','admin');

create table club_info(
    club_id BIGINT PRIMARY KEY,
    club_name VARCHAR(255)
    );

create table clubmember(
    club_id int PRIMARY KEY AUTO_INCREMENT,
    roll BIGINT 
    club_name VARCHAR(255),
    club_password VARCHAR(255),
    club_admin BIGINT,
    constraint fk_roll_club foreign key (roll) references users(roll)
);  

create table club_event(
    event_id int PRIMARY KEY AUTO_INCREMENT,
    club_id BIGINT,
    event_name VARCHAR(255),
    event_date DATE,
    event_time TIME,
    event_location VARCHAR(255),
    constraint fk_club_id foreign key (club_id) references club_info(club_id)
);





-- Create the clubs table
CREATE TABLE `clubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) DEFAULT NULL,
  `club_name` varchar(100) NOT NULL,
  `description` text,
  `founded_date` date DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `social_media` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `club_name` (`club_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample clubs data
INSERT INTO `clubs` (`club_name`, `description`, `founded_date`, `president_name`, `faculty_advisor`, `meeting_location`, `total_members`, `status`) VALUES
('Computer Club', 'The Premier University Computer Club is a student organization dedicated to promoting technology education, coding skills, and computer science knowledge among students.', '2010-06-15', 'Tahmid Ahmed', 'Dr. Rahim Khan', 'Computer Lab 3', 145, 'active'),
('Cultural Club', 'The Cultural Club celebrates diversity through various cultural activities, performances, and events that highlight the rich cultural heritage of Bangladesh.', '2008-03-22', 'Sakib Hassan', 'Prof. Nasreen Begum', 'Auditorium', 120, 'active'),
('Robotics Club', 'The Robotics Club focuses on designing, building, and programming robots for various competitions and practical applications.', '2012-11-10', 'Farhan Rahman', 'Dr. Kamal Hossain', 'Engineering Lab 2', 78, 'active'),
('Debate Club', 'The Debate Club enhances public speaking skills and critical thinking through regular debate competitions and workshops.', '2009-07-05', 'Tasneem Akter', 'Prof. Jamal Uddin', 'Room 301', 65, 'active'),
('Business Club', 'The Business Club helps students develop entrepreneurial skills through workshops, case competitions, and networking events.', '2011-02-18', 'Raisa Khan', 'Dr. Sharmin Akhter', 'Business Building Room 201', 92, 'active');

-- Create the events table
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(255) NOT NULL,
  `description` text,
  `club_id` int(11) DEFAULT NULL,
  `event_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `max_participants` int(11) DEFAULT NULL,
  `current_participants` int(11) DEFAULT,
  `registration_deadline` date DEFAULT NULL,
  `registration_link` varchar(255) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `club_id` (`club_id`),
  CONSTRAINT `event_club_fk` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample events data
INSERT INTO `events` (`event_title`, `description`, `club_id`, `event_date`, `start_time`, `end_time`, `location`, `max_participants`, `registration_deadline`, `contact_person`, `status`) VALUES
('Annual Tech Fest 2025', 'A weekend-long technology festival featuring coding competitions, hackathons, and tech talks from industry professionals.', 1, '2025-04-15', '09:00:00', '18:00:00', 'University Main Campus', 300, '2025-04-10', 'Tahmid Ahmed', 'upcoming'),
('Cultural Night', 'An evening celebrating the diverse cultural heritage of Bangladesh through music, dance, and theatrical performances.', 2, '2025-03-21', '18:00:00', '22:00:00', 'University Auditorium', 500, '2025-03-15', 'Sakib Hassan', 'upcoming'),
('Robotics Workshop', 'A hands-on workshop on building and programming basic robots using Arduino.', 3, '2025-03-12', '10:00:00', '16:00:00', 'Engineering Lab 2', 50, '2025-03-10', 'Farhan Rahman', 'upcoming'),
('Inter-University Debate Competition', 'Annual debate competition with participants from universities across Chittagong.', 4, '2025-04-05', '09:30:00', '17:00:00', 'University Conference Hall', 150, '2025-03-30', 'Tasneem Akter', 'upcoming'),
('Entrepreneurship Seminar', 'A seminar featuring successful entrepreneurs sharing their experiences and insights.', 5, '2025-03-25', '14:00:00', '17:00:00', 'Business Building Auditorium', 200, '2025-03-22', 'Raisa Khan', 'upcoming');

-- Create the news table
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `club_id` int(11) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `published_date` date NOT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `club_id` (`club_id`),
  CONSTRAINT `news_club_fk` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample news data
INSERT INTO `news` (`title`, `content`, `club_id`, `author`, `published_date`, `featured`) VALUES
('Computer Club Wins National Hackathon', 'The Premier University Computer Club team secured first place at the National Hackathon 2025 held in Dhaka. The team of five students developed an innovative solution for urban waste management using IoT devices.', 1, 'Admin', '2025-02-28', 1),
('Cultural Club to Host Cultural Festival', 'Premier University Cultural Club announces their annual cultural festival scheduled for March 21, 2025. The event will feature performances showcasing traditional Bengali culture, music, and dance.', 2, 'Admin', '2025-03-01', 1),
('Robotics Team Qualifies for International Competition', 'The Premier University Robotics Club has qualified for the International Robotics Olympiad to be held in Singapore. The team\'s autonomous robot design impressed judges during the national qualifiers.', 3, 'Admin', '2025-03-02', 0),
('Debate Club Launches Public Speaking Workshop Series', 'The Debate Club is starting a series of public speaking workshops open to all students. The workshops will focus on improving debate skills, critical thinking, and effective communication.', 4, 'Admin', '2025-03-03', 0),
('Business Club Partners with Local Entrepreneurs', 'The Business Club has established partnerships with local entrepreneurs who will mentor club members on business plan development and startup strategies.', 5, 'Admin', '2025-03-04', 0);