CREATE DATABASE bdmodificada;

DROP TABLE IF EXISTS pasajero;
DROP TABLE IF EXISTS viaje;
DROP TABLE IF EXISTS responsable;
DROP TABLE IF EXISTS persona;
DROP TABLE IF EXISTS empresa;

-- Crear tablas nuevamente
CREATE TABLE empresa (
    idempresa BIGINT AUTO_INCREMENT,
    enombre VARCHAR(150),
    edireccion VARCHAR(150),
    PRIMARY KEY (idempresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE persona (
    documento VARCHAR(15),
    nombre VARCHAR(150),
    apellido VARCHAR(150),
    PRIMARY KEY (documento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE responsable (
    rnumeroempleado BIGINT AUTO_INCREMENT,
    rnumerolicencia BIGINT,
    rdocumento VARCHAR(15),
    rnombre VARCHAR(150),
    rapellido VARCHAR(150),
    PRIMARY KEY (rnumeroempleado),
    FOREIGN KEY (rdocumento) REFERENCES persona (documento) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE viaje (
    idviaje BIGINT AUTO_INCREMENT,
    vdestino VARCHAR(150),
    vcantmaxpasajeros INT,
    idempresa BIGINT,
    rnumeroempleado BIGINT,
    vimporte FLOAT,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE pasajero (
    pdocumento VARCHAR(15),
    pnombre VARCHAR(150),
    papellido VARCHAR(150),
    ptelefono INT,
    idviaje BIGINT,
    FOREIGN KEY (pdocumento) REFERENCES persona (documento) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;