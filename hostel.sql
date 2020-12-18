CREATE TABLE `alloted_rooms` (
  `student_regno` int(11) NOT NULL,
  `roomno` int(11) NOT NULL,
  UNIQUE KEY `student_regno` (`student_regno`),
  KEY `roomno` (`roomno`),
  CONSTRAINT `alloted_rooms_ibfk_1` FOREIGN KEY (`student_regno`) REFERENCES `students` (`Regno`),
  CONSTRAINT `alloted_rooms_ibfk_2` FOREIGN KEY (`roomno`) REFERENCES `rooms` (`Roomno`),
  CONSTRAINT `alloted_rooms_ibfk_3` FOREIGN KEY (`student_regno`) REFERENCES `students` (`Regno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `room_requests` (
  `student_regno` int(11) NOT NULL,
  `roomno` int(11) NOT NULL,
  KEY `student_regno` (`student_regno`),
  KEY `roomno` (`roomno`),
  CONSTRAINT `room_requests_ibfk_1` FOREIGN KEY (`student_regno`) REFERENCES `students` (`Regno`),
  CONSTRAINT `room_requests_ibfk_2` FOREIGN KEY (`roomno`) REFERENCES `rooms` (`Roomno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `rooms` (
  `Roomno` int(11) NOT NULL,
  `Hostelname` varchar(20) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `Occupied` int(11) NOT NULL,
  `Type` varchar(10) NOT NULL,
  `Bedtype` varchar(20) NOT NULL,
  `Bathroom` varchar(20) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  PRIMARY KEY (`Roomno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `staff` (
  `StaffId` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Designation` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Age` int(11) NOT NULL,
  `Mobile` bigint(20) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Username` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL,
  PRIMARY KEY (`StaffId`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Password` (`Password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `students` (
  `Regno` int(11) NOT NULL,
  `Name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `DOB` date NOT NULL,
  `Age` int(11) NOT NULL,
  `Gender` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Dept` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Year` int(11) NOT NULL,
  `Blood_group` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Mobile` bigint(20) DEFAULT NULL,
  `Email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Nativity` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `F_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `F_mobile` bigint(20) NOT NULL,
  `F_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `F_occupation` varchar(40) NOT NULL,
  `M_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `M_mobile` bigint(20) NOT NULL,
  `M_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `M_occupation` varchar(40) NOT NULL,
  PRIMARY KEY (`Regno`),
  UNIQUE KEY `email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `users` (
  `student_regno` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`student_regno`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password` (`password`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`student_regno`) REFERENCES `students` (`Regno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
