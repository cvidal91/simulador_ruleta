

	   
CREATE TABLE public.jugador
(
   id_jugador serial, 
   nombre_jugador character varying(80) NOT NULL, 
   saldo_favor numeric(10,2) NOT NULL DEFAULT 0, 
   sw_estado character(1) DEFAULT 1, 
   fecha_registro timestamp without time zone NOT NULL DEFAULT now(), 
   fecha_modificacion timestamp without time zone, 
   fecha_eliminacion timestamp without time zone, 
   PRIMARY KEY (id_jugador), 
   UNIQUE (nombre_jugador)
) 
WITH (
  OIDS = FALSE
)
;
COMMENT ON COLUMN public.jugador.saldo_favor IS 'Saldo a favor en cuenta de jugador';
COMMENT ON COLUMN public.jugador.sw_estado IS 'Determina el estado del jugador. 0: inactivo, 1: activo, 2:eliminado';

CREATE TABLE public.estado_juego
(
   numero_juego serial, 
   estado_juego character(1) NOT NULL DEFAULT 1, 
   numero_ronda integer NOT NULL, 
   fecha_registro timestamp without time zone DEFAULT now(), 
   PRIMARY KEY (numero_juego)
) 
WITH (
  OIDS = FALSE
)
;
COMMENT ON COLUMN public.estado_juego.estado_juego IS 'Indica el estado del juego. 1:en curso, 0:terminado';
COMMENT ON COLUMN public.estado_juego.numero_ronda IS 'Indica el numero de ronda del juego de ruleta';


CREATE TABLE public.apuesta
(
   id_apuesta serial,
   numero_juego integer NOT NULL, 
   id_jugador integer, 
   valor_apuesta numeric(10,2), 
   sw_ganador character(1) DEFAULT 0, 
   color_apuesta character varying (15) NOT NULL,
   numero_ronda integer NOT NULL, 
   PRIMARY KEY (id_apuesta), 
   FOREIGN KEY (id_jugador) REFERENCES jugador (id_jugador) ON UPDATE NO ACTION ON DELETE NO ACTION
) 
WITH (
  OIDS = FALSE
)
;

COMMENT ON COLUMN public.apuesta.valor_apuesta IS 'Valor apostado por el jugador';
COMMENT ON COLUMN public.apuesta.sw_ganador IS 'Determina si la apuesta realizada gano en la ronda. 0: no gano, 1: gano';
COMMENT ON COLUMN public.apuesta.numero_ronda IS 'Indica el numero de ronda del juego de ruleta';

ALTER TABLE apuesta
  ADD FOREIGN KEY (numero_juego) REFERENCES estado_juego (numero_juego) ON UPDATE NO ACTION ON DELETE NO ACTION;



CREATE TABLE public.resultados_ruleta
(
   consecutivo serial, 
   numero_juego integer, 
   numero_ronda integer, 
   color_ganador character varying(15) NOT NULL, 
   PRIMARY KEY (consecutivo), 
   FOREIGN KEY (numero_juego) REFERENCES estado_juego (numero_juego) ON UPDATE NO ACTION ON DELETE NO ACTION
) 
WITH (
  OIDS = FALSE
)
;
