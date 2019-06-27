-- tbl_User(u_ID, p_ID)

-- tbl_Privilege(p_ID)

-- tbl_Access(a_ID, ap_ID)

-- tbl_Activitypackage(ap_ID, u_ID)

-- tbl_Notifications(n_ID, a_ID)

-- tbl_User_Access(u_ID, a_ID)

-- CHANGES: Location to Street and StreetNr




Use usr_web24279952_1;

CREATE TABLE tbl_User (
	u_ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	u_Name varchar(256) NULL,
    u_Password varchar(256) NULL,
	u_Token varchar(1000) NULL,
    u_Email varchar(256) NULL UNIQUE,
    u_Privilege varchar(20) NOT NULL
);

-- INSERTING DATA FOR TBL_USER --

insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (1, 'Skell', '$2y$10$kVmbUXcdb34k2sO0CA.bgOkCVN.//dargYGZiNJ0ANCInFKs4J67m', '', 'sdahle0@nifty.com', 'Admin'); -- test
insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (2, 'Layton', '$2y$10$WWxSCNVA5pbiSpu/1Ujcy.00mu.m7vyC48GWF8T2M7gy07wOyyku2', '', 'lstonuary1@shinystat.com', 'Normal'); -- testitest
insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (3, 'Tuckie', '$2y$10$wdI2fH4G1Kifqfj7268f8.UiJlap/DElR4hFQ8qvPKivd3RmHCuqe', '', 'talfonzo2@admin.ch', 'Guest');  -- patti_ist_mürrisch
insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (4, 'Norry', '$2y$10$t6kpZk1ejeRPoK31rGC0iuKnC8O/D0E9DfRe9iMhh97ec2o4evIjK', '', 'nmcelroy3@deviantart.com','Normal'); -- test2
insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (5, 'Alva', '$2y$10$KaFfw8smSKts.wNHRNcvz.jG.0CgXUqdrHVzHMbaaIrUlS7IXs1PC', '', 'apollington4@cyberchimps.com', 'Guest'); -- test3
insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (6, 'Dilly', '$$2y$10$iGLVSsdzJ./KZ.zuGOCPi.QXRtDnxSiMOBNKtPVD9IilSlH4cG1mq', '', 'ddecarolis5@tamu.edu', 'Normal'); -- Passwort4!
insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (7, 'Geneva', '$2y$10$sVCDM/eL35p2zQL4Fw.vkOTF7NlPSWK3PmkQRKZo3qQjIq/IbR/0S', '', 'gaynsley6@opera.com', 'Admin'); -- asdasd1234
insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (8, 'Ottilie', '$2y$10$y5d4zH5aBBdtOh.1UQdbduY2Wx6D1gxcfI/l5AuSrxO57KOIeMRr6', '', 'obliss7@tinyurl.com', 'Guest'); -- Deine_Muddi_
insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (9, 'Dal', '$2y$10$LKSQvYiWJ0ODvEIlR/BarOWyTaPlXBdBJX.ChNKVSU.rVhrITcNGe', '', 'dbrevetor8@usatoday.com', 'Admin'); -- Mamacita
insert into tbl_User (u_ID, u_Name, u_Password, u_Token, u_Email, u_Privilege) values (10, 'Stacy', '$2y$10$96b4NuPSfhRVEsP6Ir7VaOpZlx21D407LOIL9AIEoq3wFYv0ZO3sK', '', 'sgrewcock9@trellian.com', 'Guest'); -- leerer hash (wortwörtlich gemeint smh)


CREATE TABLE tbl_Activitypackage (
	ap_ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ap_Name varchar(256) NOT NULL,
	ap_Location varchar(128) NOT NULL,
	ap_Street varchar(256) NOT NULL,
	ap_StreetNr int NOT NULL,
	ap_Note varchar(256) NULL,
    ap_Date date NOT NULL,
    ap_Time time NULL,
    ap_Done boolean NOT NULL,
    FK_OwnerUser_ID int NULL,
    CONSTRAINT FK_OwnerUser FOREIGN KEY (FK_OwnerUser_ID) REFERENCES tbl_User (u_ID)
);

-- INSERTING DATA FOR TBL_ACTIVITYPACKAGE
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (1, 'Pflastern', 'Russia', 'Vahlen', '9', 'felis donec semper', '2023/06/17', '9:36', true, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (2, 'Pflastern', 'China', 'Waxwing', '3', 'blandit lacinia erat vestibulum sed', '2030/05/03', '15:51', false, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (3, 'Planung', 'France', 'Everett', '121', 'nisl aenean lectus', '2018/09/12', '18:45', false, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (4, 'Planung', 'Venezuela', '7th', '6489', 'ante ipsum primis in', '2018/09/05', '12:12', false, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (5, 'Einkauf', 'Ukraine', 'Northland', '1', 'faucibus orci luctus et ultrices', '2018/03/30', '9:25', false, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (6, 'Einkauf', 'China', 'Bashford', '2119', 'tincidunt eget tempus', '2018/03/17', '9:52', true, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (7, 'Verkauf', 'Portugal', 'Eastlawn', '38', 'diam vitae quam suspendisse', '2018/11/27', '8:12', true, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (8, 'Pflastern', 'France', 'Havey', '4886', 'sociis natoque penatibus et', '2030/01/20', '9:15', false, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (9, 'Verkauf', 'Philippines', 'Laurel', '45', 'non mauris morbi', '2018/09/26', '10:49', false, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (10, 'Verkauf', 'Russia', 'Fremont', '0097', 'duis aliquam convallis nunc', '2018/07/14', '9:49', false, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (11, 'Pflastern', 'Indonesia', 'Fremont', '01', 'duis faucibus accumsan', '2018/12/12', '11:30', true, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (12, 'Renovieren', 'Indonesia', 'Brickson Park', '73', 'leo odio condimentum id luctus', '2018/12/28', '10:06', true, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (13, 'Pflastern', 'Lithuania', 'Shelley', '9952', 'est lacinia nisi venenatis tristique', '2018/05/01', '16:10', false, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (14, 'Pflastern', 'France', 'Union', '1', 'sapien ut nunc vestibulum ante', '2030/03/23', '9:24', true, 8);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (15, 'Pflastern', 'Russia', 'Bonner', '97558', 'morbi porttitor lorem id ligula', '2019/02/09', '18:53', false, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (16, 'Renovieren', 'Peru', 'Kenwood', '9', 'vitae mattis nibh', '2019/01/18', '15:55', true, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (17, 'Planung', 'China', 'Packers', '81', 'augue vestibulum rutrum', '2030/03/17', '9:54', false, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (18, 'Planung', 'Poland', 'Forest Run', '402', 'consequat ut nulla', '2018/03/22', '12:58', false, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (19, 'Dokumentation', 'Tunisia', 'Pennsylvania', '25346', 'volutpat in congue etiam justo', '2019/02/01', '15:32', true, 5);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (20, 'Verkauf', 'Peru', 'Northview', '950', 'suspendisse potenti nullam', '2018/06/06', '9:14', true, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (21, 'Renovieren', 'Sweden', 'Loeprich', '1870', 'ipsum integer a nibh in', '2019/05/10', '18:30', true, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (22, 'Pflastern', 'Argentina', 'Manitowish', '64', 'ut nulla sed accumsan', '2018/09/30', '9:44', false, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (23, 'Planung', 'Czech Republic', 'Barnett', '22246', 'nunc viverra dapibus', '2018/04/05', '15:21', true, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (24, 'Pflastern', 'Argentina', 'Di Loreto', '8', 'ante vel ipsum', '2018/03/13', '18:21', true, 10);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (25, 'Renovieren', 'Peru', 'Dorton', '1', 'ut massa quis augue luctus', '2018/03/13', '17:57', false, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (26, 'Pflastern', 'Thailand', 'Russell', '5992', 'ultrices mattis odio donec', '2018/04/16', '16:00', false, 8);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (27, 'Dokumentation', 'Argentina', 'Orin', '001', 'sapien in sapien iaculis congue', '2019/01/22', '12:52', true, 8);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (28, 'Renovieren', 'Sweden', 'Reindahl', '09206', 'sapien ut nunc vestibulum ante', '2019/04/08', '14:35', false, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (29, 'Pflastern', 'Brazil', 'Fairfield', '415', 'elit sodales scelerisque mauris sit', '2018/07/03', '12:17', false, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (30, 'Einkauf', 'Syria', 'David', '88559', 'pellentesque volutpat dui maecenas tristique', '2018/11/19', '8:22', true, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (31, 'Planung', 'Sierra Leone', 'Shoshone', '9856', 'curabitur convallis duis consequat dui', '2018/03/28', '12:34', false, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (32, 'Einkauf', 'Brazil', 'La Follette', '00', 'nibh in hac habitasse', '2018/05/02', '14:33', true, 5);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (33, 'Pflastern', 'Bolivia', 'Golf', '9291', 'blandit mi in porttitor pede', '2018/07/11', '9:09', false, 5);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (34, 'Verkauf', 'Finland', 'Crescent Oaks', '3981', 'viverra eget congue', '2018/11/12', '16:17', false, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (35, 'Dokumentation', 'Indonesia', 'Little Fleur', '8085', 'hac habitasse platea', '2018/12/14', '12:56', true, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (36, 'Verkauf', 'Portugal', 'Utah', '4', 'nec nisi volutpat eleifend donec', '2023/08/31', '17:49', true, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (37, 'Planung', 'Philippines', 'Reindahl', '8157', 'porttitor lacus at turpis donec', '2018/11/18', '12:33', true, 8);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (38, 'Planung', 'Indonesia', 'Reindahl', '71', 'nec sem duis aliquam', '2023/02/21', '13:30', false, 8);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (39, 'Renovieren', 'Mexico', 'Waubesa', '81', 'metus sapien ut nunc vestibulum', '2018/06/13', '12:23', true, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (40, 'Pflastern', 'Armenia', 'Talmadge', '49', 'aenean sit amet justo', '2023/04/27', '16:35', true, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (41, 'Pflastern', 'China', 'Bartelt', '97716', 'blandit non interdum in', '2023/03/28', '10:41', false, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (42, 'Verkauf', 'Portugal', 'Bultman', '740', 'purus sit amet', '2018/07/30', '16:33', true, 10);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (43, 'Planung', 'Syria', 'Hallows', '87', 'eros vestibulum ac est lacinia', '2018/08/17', '17:46', true, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (44, 'Renovieren', 'Philippines', 'Springs', '283', 'nulla ac enim in', '2018/09/03', '12:21', false, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (45, 'Einkauf', 'Albania', 'Oakridge', '4992', 'bibendum imperdiet nullam', '2019/04/25', '8:03', true, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (46, 'Pflastern', 'Moldova', 'Clove', '4568', 'penatibus et magnis dis', '2019/04/08', '17:08', true, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (47, 'Pflastern', 'China', 'Nova', '18', 'sit amet nulla', '2018/07/01', '13:34', true, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (48, 'Einkauf', 'Peru', 'Esch', '4912', 'nunc rhoncus dui vel', '2018/04/02', '8:42', true, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (49, 'Verkauf', 'Russia', 'Browning', '1', 'eget vulputate ut', '2019/05/30', '18:16', false, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (50, 'Dokumentation', 'China', 'Hauk', '5100', 'interdum venenatis turpis enim', '2018/06/15', '17:16', false, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (51, 'Dokumentation', 'Brazil', 'Meadow Valley', '5084', 'vulputate justo in', '2023/03/27', '11:13', true, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (52, 'Verkauf', 'China', 'Lotheville', '72', 'metus aenean fermentum donec', '2023/04/16', '10:44', false, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (53, 'Dokumentation', 'Brazil', 'Maple', '60977', 'sem fusce consequat nulla nisl', '2018/07/10', '10:37', true, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (54, 'Dokumentation', 'Venezuela', 'Mccormick', '24', 'volutpat convallis morbi odio odio', '2018/08/22', '18:44', false, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (55, 'Einkauf', 'China', 'International', '67248', 'nunc donec quis', '2018/03/03', '9:40', false, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (56, 'Renovieren', 'Czech Republic', 'Carberry', '38', 'amet consectetuer adipiscing elit proin', '2019/01/09', '12:42', true, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (57, 'Pflastern', 'China', 'Westport', '532', 'pede ac diam', '2018/10/04', '18:45', false, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (58, 'Verkauf', 'Philippines', 'Di Loreto', '54', 'ut blandit non', '2018/07/29', '15:53', true, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (59, 'Renovieren', 'Belarus', 'Dexter', '02654', 'luctus tincidunt nulla', '2018/12/10', '18:34', false, 10);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (60, 'Renovieren', 'Philippines', 'Muir', '984', 'lacinia nisi venenatis tristique', '2018/06/24', '10:43', true, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (61, 'Planung', 'Cuba', 'Harper', '112', 'justo eu massa', '2019/04/06', '12:15', true, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (62, 'Dokumentation', 'China', 'Blackbird', '86725', 'posuere cubilia curae donec', '2018/05/16', '16:35', false, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (63, 'Einkauf', 'China', 'Walton', '08', 'ac lobortis vel dapibus', '2018/10/31', '15:46', false, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (64, 'Planung', 'China', 'Cascade', '3828', 'aenean lectus pellentesque', '2018/07/26', '10:18', true, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (65, 'Renovieren', 'Mexico', 'International', '60', 'est lacinia nisi venenatis', '2019/04/21', '13:40', true, 8);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (66, 'Planung', 'China', 'Springs', '76', 'eget orci vehicula condimentum curabitur', '2018/07/22', '12:45', true, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (67, 'Verkauf', 'Iran', 'Pennsylvania', '1807', 'ultrices posuere cubilia curae donec', '2018/03/18', '8:33', false, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (68, 'Renovieren', 'France', 'Pankratz', '1305', 'odio donec vitae', '2018/05/09', '15:03', false, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (69, 'Einkauf', 'China', 'Briar Crest', '6', 'donec semper sapien', '2019/06/20', '14:05', true, 10);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (70, 'Verkauf', 'Romania', 'Sheridan', '3132', 'dolor vel est donec', '2018/04/29', '8:10', true, 10);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (71, 'Pflastern', 'China', 'Victoria', '242', 'morbi a ipsum integer a', '2018/04/15', '18:20', true, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (72, 'Einkauf', 'Philippines', 'Utah', '804', 'vivamus in felis', '2018/03/02', '8:58', true, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (73, 'Verkauf', 'China', 'Acker', '06', 'semper interdum mauris', '2019/01/27', '10:19', true, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (74, 'Einkauf', 'Russia', 'Spaight', '71932', 'sem sed sagittis nam', '2018/12/01', '14:59', false, 5);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (75, 'Planung', 'Indonesia', 'Birchwood', '592', 'porttitor lacus at turpis', '2019/05/09', '17:45', false, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (76, 'Verkauf', 'Philippines', 'International', '670', 'suspendisse ornare consequat lectus in', '2018/12/31', '15:19', false, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (77, 'Pflastern', 'Chile', 'Tennyson', '33816', 'ut ultrices vel augue', '2018/06/06', '11:06', true, 10);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (78, 'Renovieren', 'China', 'Moose', '5341', 'donec semper sapien a', '2018/08/12', '9:53', false, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (79, 'Dokumentation', 'United Kingdom', 'Kim', '8', 'elit proin interdum mauris', '2019/05/03', '18:21', true, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (80, 'Dokumentation', 'Indonesia', 'Londonderry', '2760', 'lobortis convallis tortor', '2018/10/05', '9:48', true, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (81, 'Einkauf', 'Thailand', 'Prentice', '0', 'tristique est et', '2018/07/26', '13:59', false, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (82, 'Pflastern', 'China', 'Forest Dale', '28940', 'duis mattis egestas metus aenean', '2018/06/19', '15:46', true, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (83, 'Pflastern', 'Peru', 'Talisman', '7', 'eu tincidunt in leo maecenas', '2018/07/15', '17:17', true, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (84, 'Planung', 'China', 'Morning', '9007', 'sit amet lobortis', '2019/04/15', '18:34', true, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (85, 'Renovieren', 'China', 'Nova', '4', 'metus arcu adipiscing molestie hendrerit', '2019/01/20', '11:42', true, 8);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (86, 'Pflastern', 'United States', 'West', '5', 'ut erat id', '2019/06/11', '15:55', false, 10);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (87, 'Einkauf', 'Panama', 'Holmberg', '9', 'imperdiet et commodo', '2018/10/02', '10:19', false, 3);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (88, 'Einkauf', 'Canada', 'Welch', '573', 'magna vestibulum aliquet', '2019/06/28', '17:15', false, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (89, 'Verkauf', 'Indonesia', 'Bobwhite', '8', 'amet sapien dignissim vestibulum', '2019/03/04', '15:32', true, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (90, 'Pflastern', 'Indonesia', 'Myrtle', '19', 'facilisi cras non velit nec', '2019/05/02', '18:21', true, 8);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (91, 'Pflastern', 'China', 'Reindahl', '473', 'id nulla ultrices aliquet maecenas', '2018/03/07', '17:34', true, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (92, 'Planung', 'China', 'Chinook', '5', 'nulla pede ullamcorper augue', '2018/09/24', '17:08', false, 4);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (93, 'Pflastern', 'Guatemala', 'Beilfuss', '653', 'vel augue vestibulum rutrum', '2018/11/15', '12:54', false, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (94, 'Verkauf', 'China', 'Susan', '4', 'cras in purus eu', '2019/05/25', '9:15', true, 6);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (95, 'Einkauf', 'China', 'Merry', '7', 'fermentum justo nec', '2018/05/24', '14:10', false, 1);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (96, 'Dokumentation', 'Honduras', 'Bayside', '74493', 'sit amet sapien dignissim vestibulum', '2019/05/21', '9:55', true, 2);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (97, 'Renovieren', 'China', 'Charing Cross', '0102', 'etiam vel augue vestibulum', '2018/06/23', '16:44', false, 7);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (98, 'Dokumentation', 'Macedonia', 'Ridgeview', '61166', 'cursus vestibulum proin', '2018/05/09', '14:22', true, 9);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (99, 'Pflastern', 'Brazil', 'Oak Valley', '450', 'interdum mauris non ligula', '2018/11/10', '10:40', false, 5);
insert into tbl_Activitypackage (ap_ID, ap_Name, ap_Location, ap_Street, ap_StreetNr, ap_Note, ap_Date, ap_Time, ap_Done, FK_OwnerUser_ID) values (100, 'Einkauf', 'Thailand', 'Heffernan', '6', 'porttitor lorem id', '2018/09/10', '15:43', false, 3);





CREATE TABLE tbl_Access (
	a_ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	FK_Activitypackage_ID int NULL,
	CONSTRAINT FK_Activitypackage FOREIGN KEY (FK_Activitypackage_ID) REFERENCES tbl_Activitypackage(ap_ID) ON DELETE CASCADE
);

-- INSERTING DATA FOR TBL_ACCESS

insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (1, 1);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (2, 2);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (3, 3);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (4, 4);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (5, 5);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (6, 6);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (7, 7);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (8, 8);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (9, 9);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (10, 10);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (11, 11);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (12, 12);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (13, 13);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (14, 14);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (15, 15);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (16, 16);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (17, 17);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (18, 18);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (19, 19);
insert into tbl_Access (a_ID, FK_Activitypackage_ID) values (20, 20);

CREATE TABLE tbl_Notification (
	n_ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	n_Done boolean NULL,
	FK_AccessN_ID int NULL,

    	CONSTRAINT FK_AccessN FOREIGN KEY (FK_AccessN_ID) REFERENCES tbl_Access (a_ID) ON DELETE CASCADE
);

-- INSERTING DATA FOR TBL_NOTIFICATION
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (1, 15, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (2, 18, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (3, 4, true);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (4, 17, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (5, 9, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (6, 6, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (7, 18, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (8, 10, true);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (9, 2, true);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (10, 12, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (11, 4, true);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (12, 11, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (13, 13, true);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (14, 6, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (15, 11, true);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (16, 16, false);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (17, 4, true);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (18, 1, true);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (19, 2, true);
insert into tbl_Notification (n_ID, FK_AccessN_ID, n_Done) values (20, 4, true);


CREATE TABLE tbl_User_Access(
	FK_User_ID int NULL,
	FK_AccessU_ID int NULL,
	CONSTRAINT FK_User FOREIGN KEY (FK_User_ID) REFERENCES tbl_User(u_ID),
	CONSTRAINT FK_AccessU FOREIGN KEY (FK_AccessU_ID) REFERENCES tbl_Access(a_ID) ON DELETE CASCADE

);

-- INSERTING DATA FOR TBL_USER_ACCESS
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (1, 1);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (2, 1);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (3, 1);

insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (2, 2);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (3, 2);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (4, 2);

insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (3, 3);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (4, 3);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (5, 3);

insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (4, 4);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (5, 4);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (6, 4);

insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (5, 5);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (7, 5);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (8, 5);

insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (6, 6);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (2, 6);

insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (7, 7);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (5, 7);

insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (8, 8);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (6, 8);

insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (9, 9);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (8, 9);

insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (10, 10);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (1, 11);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (2, 12);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (3, 13);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (4, 14);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (5, 15);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (6, 16);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (7, 17);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (8, 18);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (9, 19);
insert into tbl_User_Access (FK_User_ID, FK_AccessU_ID) values (10, 20);

CREATE TABLE tbl_Archive_Activitypackage (
	ap_archive_ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ap_archive_Name varchar(256) NOT NULL,
	ap_archive_Location varchar(128) NOT NULL,
	ap_archive_Street varchar(256) NOT NULL,
	ap_archive_StreetNr int NOT NULL,
	ap_archive_Note varchar(256) NULL,
	ap_archive_Date date NOT NULL,
	ap_archive_Time time NULL,
	ap_archive_Done boolean NOT NULL,
	ap_archive_owner varchar(50) NOT NULL
);


DELIMITER |

CREATE EVENT moveOldActivitypackagesToArchive
    ON SCHEDULE EVERY 1 MINUTE
    DO
      BEGIN
      INSERT INTO tbl_Archive_Activitypackage (ap_archive_ID, ap_archive_Name, ap_archive_Location, ap_archive_Street,ap_archive_StreetNr,ap_archive_Note,ap_archive_Date,ap_archive_Time,ap_archive_Done,ap_archive_owner)

      SELECT
      a.ap_ID,
      a.ap_Name,
      a.ap_Location,
      a.ap_Street,
      a.ap_StreetNr,
      a.ap_Note,
      a.ap_Date,
      a.ap_Time,
      a.ap_Done,
      u.u_Email
      FROM tbl_Activitypackage a INNER JOIN tbl_User u ON u.u_ID = a.FK_OwnerUser_ID
      WHERE ap_Date > (CURDATE() + INTERVAL 2 YEAR);

      UPDATE tbl_Activitypackage SET FK_OwnerUser_ID = NULL WHERE ap_Date > (CURDATE() + INTERVAL 2 YEAR);

      SET FOREIGN_KEY_CHECKS=0;
      DELETE FROM tbl_Activitypackage WHERE FK_OwnerUser_ID IS NULL;
      SET FOREIGN_KEY_CHECKS=1;

      END |

DELIMITER ;





