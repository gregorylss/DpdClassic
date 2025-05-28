-- Update script for DpdClassic module version 2.0.8
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `dpd_classic_price_slice` (
                                                         `id` INT NOT NULL AUTO_INCREMENT,
                                                         `area_id` INT NOT NULL,
                                                         `max_weight` FLOAT NOT NULL,
                                                         `price` FLOAT NOT NULL,
                                                         `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                         `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                                         PRIMARY KEY (`id`),
    CONSTRAINT `fk_dpd_classic_price_slice_area_id`
    FOREIGN KEY (`area_id`)
    REFERENCES `area` (`id`)
    ON UPDATE RESTRICT
    ON DELETE RESTRICT
    ) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS dpd_classic_sender_config (
                                           id SERIAL PRIMARY KEY,
                                           name VARCHAR(255) NOT NULL,
                                           primary_adress VARCHAR(255) NOT NULL,
                                           secondary_adress VARCHAR(255),
                                           zip_code VARCHAR(10) NOT NULL,
                                           city VARCHAR(100) NOT NULL,
                                           phone VARCHAR(20) NOT NULL,
                                            mobile_phone VARCHAR(20) NOT NULL,
                                           email VARCHAR(255) NOT NULL,
                                           dpd_code VARCHAR(20) NOT NULL,
                                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


SET FOREIGN_KEY_CHECKS = 1;
