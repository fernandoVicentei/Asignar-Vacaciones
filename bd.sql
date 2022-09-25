create database bd_prueba_tecnica

CREATE TABLE `personal` (
  id int(11) PRIMARY KEY auto_increment,
  nombre varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  apellido varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  area_trabajo varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) 



CREATE TABLE `vacacion` (
  id int(11) PRIMARY KEY auto_increment,
  personal_id int(11) NOT NULL,
  fecha_vacacion date NOT NULL,
  fecha_fin_vacacion date NOT NULL,
  aprobado bool NOT NULL,
  FOREIGN KEY (personal_id) REFERENCES personal(id)
	
) 
