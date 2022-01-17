use CYMA_Utility;

CREATE TABLE `transactions_ap_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_source` varchar(32) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_processed` longtext,
  `result_status` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

CREATE TABLE `transactions_ap_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_source` varchar(32) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_processed` longtext,
  `result_status` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

CREATE TABLE `transactions_ar_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_source` varchar(32) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_processed` longtext,
  `result_status` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=494 DEFAULT CHARSET=latin1;

CREATE TABLE `transactions_ar_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_source` varchar(32) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_processed` longtext,
  `result_status` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=477 DEFAULT CHARSET=latin1;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLogData`(
	IN  p_data_source VARCHAR(32),
	IN  p_data_processed VARCHAR(2048), 
    IN  p_result_status VARCHAR(32)
)
BEGIN
INSERT INTO transactions
         (
           data_source, 
           data_processed, 
           result_status                    
         )
    VALUES 
         ( 
           p_data_source, 
           p_data_processed, 
           p_result_status                              
         ) ; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLogDataAP`(
    IN  p_data_source VARCHAR(32),
    IN  p_data_processed VARCHAR(2048), 
    IN  p_result_status VARCHAR(32)
)
BEGIN
INSERT INTO transactions_ap
(
    data_source, 
    data_processed, 
    result_status                    
)
VALUES 
( 
    p_data_source, 
    p_data_processed, 
    p_result_status                              
) ; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLogDataAPIn`(
    IN  p_data_source VARCHAR(32),
    IN  p_data_processed LONGTEXT, 
    IN  p_result_status VARCHAR(32)
)
BEGIN
INSERT INTO transactions_ap_in
(
    data_source, 
    data_processed, 
    result_status                    
)
VALUES 
( 
    p_data_source, 
    p_data_processed, 
    p_result_status                              
) ; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLogDataAPOut`(
    IN  p_data_source VARCHAR(32),
    IN  p_data_processed LONGTEXT, 
    IN  p_result_status VARCHAR(32)
)
BEGIN
INSERT INTO transactions_ap_out
(
    data_source, 
    data_processed, 
    result_status                    
)
VALUES 
( 
    p_data_source, 
    p_data_processed, 
    p_result_status                              
) ; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLogDataAR`(
    IN  p_data_source VARCHAR(32),
    IN  p_data_processed VARCHAR(2048), 
    IN  p_result_status VARCHAR(32)
)
BEGIN
INSERT INTO transactions_ar
(
    data_source, 
    data_processed, 
    result_status                    
)
VALUES 
( 
    p_data_source, 
    p_data_processed, 
    p_result_status                              
) ; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLogDataARIn`(
    IN  p_data_source VARCHAR(32),
    IN	p_data_processed LONGTEXT,
    IN  p_result_status VARCHAR(32)
)
BEGIN
INSERT INTO transactions_ar_in
(
    data_source, 
    data_processed, 
    result_status                    
)
VALUES 
( 
    p_data_source, 
    p_data_processed, 
    p_result_status                              
) ; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertLogDataAROut`(
    IN  p_data_source VARCHAR(32),
    IN  p_data_processed LONGTEXT, 
    IN  p_result_status VARCHAR(32)
)
BEGIN
INSERT INTO transactions_ar_out
(
    data_source, 
    data_processed, 
    result_status                    
)
VALUES 
( 
    p_data_source, 
    p_data_processed, 
    p_result_status                              
) ; 
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `testproc`(OUT param1 INT)
BEGIN
SELECT COUNT(*) INTO param1 FROM transactions;
END$$
DELIMITER ;











