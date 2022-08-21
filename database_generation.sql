ALTER TABLE Client DROP FOREIGN KEY FKClient606918;
ALTER TABLE Records DROP FOREIGN KEY FKRecords133403;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Records;
CREATE TABLE `User` (
                        Id       int(10) NOT NULL AUTO_INCREMENT,
                        username varchar(55) NOT NULL,
                        password varchar(55) NOT NULL,
                        PRIMARY KEY (Id));
CREATE TABLE Client (
                        id int(10) NOT NULL AUTO_INCREMENT,
                        name     varchar(55) NOT NULL,
                        UserId   int(10) NOT NULL,
                        PRIMARY KEY (id));
CREATE TABLE Records (
                         Id             int(10) NOT NULL AUTO_INCREMENT,
                         RecordDate     varchar(55) NOT NULL,
                         Solar          double NOT NULL,
                         Eolic          int(10) NOT NULL,
                         ClientId int(10) NOT NULL,
                         PRIMARY KEY (Id));
ALTER TABLE Client ADD CONSTRAINT FKClient606918 FOREIGN KEY (UserId) REFERENCES `User` (Id);
ALTER TABLE Records ADD CONSTRAINT FKRecords133403 FOREIGN KEY (ClientId) REFERENCES Client (id);

INSERT INTO `user` (`Id`, `username`, `password`) VALUES
                                                      (1, 'admin', 'admin'),
                                                      (2, 'joseph', 'jose123'),
                                                      (3, 'miguel', 'miguel123');


INSERT INTO `client` (`Id`, `name`, `UserId`) VALUES
                                                  (1, 'Joseph', 2),
                                                  (2, 'Miguel', 3);