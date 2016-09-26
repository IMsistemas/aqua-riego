drop index ACTIVIDAD_PK;

drop table ACTIVIDAD;

drop index AREADETARIFA_FK;

drop table AREA;

drop index PARROQUIAABARIIO_FK;

drop index BARRIO_PK;

drop table BARRIO;

drop index BARRIOACALLE_FK;

drop index CALLE_PK;

drop table CALLE;

drop index CANAL_PK;

drop table CANAL;

drop index PROVINCIAACANTON_FK;

drop index CANTON_PK;

drop table CANTON;

drop index CARGO_PK;

drop table CARGO;

drop index CAUDALDETARIFA_FK;

drop table CAUDAL;

drop index ACTIVIDADACLIENTE_FK;

drop index PROFESIONACLIENTE_FK;

drop index CLIENTE_PK;

drop table CLIENTE;

drop index TERRENOACOBRO_FK;

drop index COBROAGUA_PK;

drop table COBROAGUA;

drop table CONFIGURACION;

drop index CULTIVO_PK;

drop table CULTIVO;

drop index TOMAADERIVACION_FK;

drop index DERIVACION_PK;

drop table DERIVACION;

drop index CARGOAEMPLEADO_FK;

drop index EMPLEADO_PK;

drop table EMPLEADO;

drop index CANTONAPARROQUIA_FK;

drop index PARROQUIA_PK;

drop table PARROQUIA;

drop index PROFESION_PK;

drop table PROFESION;

drop index PROVINCIA_PK;

drop table PROVINCIA;

drop index CLIENTEASOLICITUD_FK;

drop index SOLICITUD_PK;

drop table SOLICITUD;

drop index TARIFA_PK;

drop table TARIFA;

drop index BARRIOATERRENO_FK;

drop index DERIVACIONATERRENO_FK;

drop index CLIENTEATERRENO_FK;

drop index TARIFAATERRENO_FK;

drop index TERRENOACULTIVO_FK;

drop index TERRENO_PK;

drop table TERRENO;

drop index CANALATOMA_FK;

drop index TOMA_PK;

drop table TOMA;

/*==============================================================*/
/* Table: ACTIVIDAD                                             */
/*==============================================================*/
create table ACTIVIDAD (
   IDACTIVIDAD          INT8                 not null,
   NOMBREACTIVIDAD      VARCHAR(512)         null,
   constraint PK_ACTIVIDAD primary key (IDACTIVIDAD)
);

/*==============================================================*/
/* Index: ACTIVIDAD_PK                                          */
/*==============================================================*/
create unique index ACTIVIDAD_PK on ACTIVIDAD (
IDACTIVIDAD
);

/*==============================================================*/
/* Table: AREA                                                  */
/*==============================================================*/
create table AREA (
   IDTARIFA             SERIAL                 not null,
   DESDE                DECIMAL(9,2)         null,
   HASTA                DECIMAL(9,2)         null,
   COSTO                DECIMAL(9,2)         null,
   ESFIJA               BOOL                 null
);

/*==============================================================*/
/* Index: AREADETARIFA_FK                                       */
/*==============================================================*/
create  index AREADETARIFA_FK on AREA (
IDTARIFA
);

/*==============================================================*/
/* Table: BARRIO                                                */
/*==============================================================*/
create table BARRIO (
   IDBARRIO             SERIAL              not null,
   IDPARROQUIA          CHAR(8)              not null,
   NOMBREBARRIO         CHAR(16)             null,
   constraint PK_BARRIO primary key (IDBARRIO)
);

/*==============================================================*/
/* Index: BARRIO_PK                                             */
/*==============================================================*/
create unique index BARRIO_PK on BARRIO (
IDBARRIO
);

/*==============================================================*/
/* Index: PARROQUIAABARIIO_FK                                   */
/*==============================================================*/
create  index PARROQUIAABARIIO_FK on BARRIO (
IDPARROQUIA
);

/*==============================================================*/
/* Table: CALLE                                                 */
/*==============================================================*/
create table CALLE (
   IDCALLE              SERIAL              not null,
   IDBARRIO             CHAR(8)              not null,
   NOMBRECALLE          CHAR(32)             null,
   constraint PK_CALLE primary key (IDCALLE)
);

/*==============================================================*/
/* Index: CALLE_PK                                              */
/*==============================================================*/
create unique index CALLE_PK on CALLE (
IDCALLE
);

/*==============================================================*/
/* Index: BARRIOACALLE_FK                                       */
/*==============================================================*/
create  index BARRIOACALLE_FK on CALLE (
IDBARRIO
);

/*==============================================================*/
/* Table: CANAL                                                 */
/*==============================================================*/
create table CANAL (
   IDCANAL              SERIAL                 not null,
   DESCRIPCIONCANAL     VARCHAR(64)          null,
   constraint PK_CANAL primary key (IDCANAL)
);

/*==============================================================*/
/* Index: CANAL_PK                                              */
/*==============================================================*/
create unique index CANAL_PK on CANAL (
IDCANAL
);

/*==============================================================*/
/* Table: CANTON                                                */
/*==============================================================*/
create table CANTON (
   IDCANTON             SERIAL              not null,
   IDPROVINCIA          CHAR(8)              not null,
   NOMBRECANTON         CHAR(32)             null,
   constraint PK_CANTON primary key (IDCANTON)
);

/*==============================================================*/
/* Index: CANTON_PK                                             */
/*==============================================================*/
create unique index CANTON_PK on CANTON (
IDCANTON
);

/*==============================================================*/
/* Index: PROVINCIAACANTON_FK                                   */
/*==============================================================*/
create  index PROVINCIAACANTON_FK on CANTON (
IDPROVINCIA
);

/*==============================================================*/
/* Table: CARGO                                                 */
/*==============================================================*/
create table CARGO (
   IDCARGO              CHAR(8)              not null,
   NOMBRECARGO          CHAR(16)             null,
   constraint PK_CARGO primary key (IDCARGO)
);

/*==============================================================*/
/* Index: CARGO_PK                                              */
/*==============================================================*/
create unique index CARGO_PK on CARGO (
IDCARGO
);

/*==============================================================*/
/* Table: CAUDAL                                                */
/*==============================================================*/
create table CAUDAL (
   IDTARIFA             SERIAL                 not null,
   DESDE                DECIMAL(9,2)         null,
   HASTA                DECIMAL(9,2)         null
);

/*==============================================================*/
/* Index: CAUDALDETARIFA_FK                                     */
/*==============================================================*/
create  index CAUDALDETARIFA_FK on CAUDAL (
IDTARIFA
);

/*==============================================================*/
/* Table: CLIENTE                                               */
/*==============================================================*/
create table CLIENTE (
   CODIGOCLIENTE        SERIAL                 not null,
   IDPROFESION          INT8                 not null,
   IDACTIVIDAD          INT8                 not null,
   DOCUMENTOIDENTIDAD   VARCHAR(32)          null,
   FECHAINGRESO         DATE                 null,
   APELLIDO             VARCHAR(32)          null,
   NOMBRE               VARCHAR(32)          null,
   CELULAR              VARCHAR(16)          null,
   CORREO               VARCHAR(32)          null,
   DIRECCIONDOMICILIO   VARCHAR(128)         null,
   TELEFONOPRINCIPALDOMICILIO VARCHAR(16)          null,
   TELEFONOSECUNDARIODOMICILIO VARCHAR(16)          null,
   DIRECCIONTRABAJO     VARCHAR(128)         null,
   TELEFONOPRINCIPALTRABAJO VARCHAR(16)          null,
   TELEFONOSECUNDARIOTRABAJO VARCHAR(16)          null,
   ESTAACTIVO           BOOL                 null,
   constraint PK_CLIENTE primary key (CODIGOCLIENTE)
);

/*==============================================================*/
/* Index: CLIENTE_PK                                            */
/*==============================================================*/
create unique index CLIENTE_PK on CLIENTE (
CODIGOCLIENTE
);

/*==============================================================*/
/* Index: PROFESIONACLIENTE_FK                                  */
/*==============================================================*/
create  index PROFESIONACLIENTE_FK on CLIENTE (
IDPROFESION
);

/*==============================================================*/
/* Index: ACTIVIDADACLIENTE_FK                                  */
/*==============================================================*/
create  index ACTIVIDADACLIENTE_FK on CLIENTE (
IDACTIVIDAD
);

/*==============================================================*/
/* Table: COBROAGUA                                             */
/*==============================================================*/
create table COBROAGUA (
   IDCUENTA             SERIAL                 not null,
   IDTERRENO            INT8                 not null,
   FECHAPERIODO         DATE                 null,
   ANIOSATRASADOS       INT4                 null,
   VALORATRASADOS       DECIMAL(9,2)         null,
   VALORCONSUMO         DECIMAL(9,2)         null,
   TOTAL                DECIMAL(9,2)         null,
   ESTAPAGADA           BOOL                 null,
   constraint PK_COBROAGUA primary key (IDCUENTA)
);

/*==============================================================*/
/* Index: COBROAGUA_PK                                          */
/*==============================================================*/
create unique index COBROAGUA_PK on COBROAGUA (
IDCUENTA
);

/*==============================================================*/
/* Index: TERRENOACOBRO_FK                                      */
/*==============================================================*/
create  index TERRENOACOBRO_FK on COBROAGUA (
IDTERRENO
);

/*==============================================================*/
/* Table: CONFIGURACION                                         */
/*==============================================================*/
create table CONFIGURACION (
   NOMBREJUNTA          VARCHAR(1512)        null,
   LOGOJUNTA            VARCHAR(1024)        null,
   ESTAENPRODUCCION     BOOL                 null,
   CONSTANTE            DECIMAL(9,2)         null
);

/*==============================================================*/
/* Table: CULTIVO                                               */
/*==============================================================*/
create table CULTIVO (
   IDCULTIVO            SERIAL                 not null,
   NOMBRECULTIVO        VARCHAR(64)          null,
   constraint PK_CULTIVO primary key (IDCULTIVO)
);

/*==============================================================*/
/* Index: CULTIVO_PK                                            */
/*==============================================================*/
create unique index CULTIVO_PK on CULTIVO (
IDCULTIVO
);

/*==============================================================*/
/* Table: DERIVACION                                            */
/*==============================================================*/
create table DERIVACION (
   IDDERIVACION         SERIAL                 not null,
   IDTOMA               INT8                 not null,
   DESCRIPCIONDERIVACION VARCHAR(64)          null,
   constraint PK_DERIVACION primary key (IDDERIVACION)
);

/*==============================================================*/
/* Index: DERIVACION_PK                                         */
/*==============================================================*/
create unique index DERIVACION_PK on DERIVACION (
IDDERIVACION
);

/*==============================================================*/
/* Index: TOMAADERIVACION_FK                                    */
/*==============================================================*/
create  index TOMAADERIVACION_FK on DERIVACION (
IDTOMA
);

/*==============================================================*/
/* Table: EMPLEADO                                              */
/*==============================================================*/
create table EMPLEADO (
   DOCUMENTOIDENTIDADEMPLEADO VARCHAR(32)          not null,
   IDCARGO              CHAR(8)              not null,
   FECHAINGRESO         DATE                 null,
   APELLIDO             VARCHAR(32)          null,
   NOMBRE               VARCHAR(32)          null,
   TELEFONOPRINCIPAL    CHAR(16)             null,
   TELEFONOSECUNDARIO   CHAR(16)             null,
   CELULAR              VARCHAR(16)          null,
   DIRECCION            VARCHAR(32)          null,
   CORREO               VARCHAR(32)          null,
   FOTO                 VARCHAR(1024)        null,
   SALARIO              DECIMAL(9,2)         null,
   constraint PK_EMPLEADO primary key (DOCUMENTOIDENTIDADEMPLEADO)
);

/*==============================================================*/
/* Index: EMPLEADO_PK                                           */
/*==============================================================*/
create unique index EMPLEADO_PK on EMPLEADO (
DOCUMENTOIDENTIDADEMPLEADO
);

/*==============================================================*/
/* Index: CARGOAEMPLEADO_FK                                     */
/*==============================================================*/
create  index CARGOAEMPLEADO_FK on EMPLEADO (
IDCARGO
);

/*==============================================================*/
/* Table: PARROQUIA                                             */
/*==============================================================*/
create table PARROQUIA (
   IDPARROQUIA          SERIAL              not null,
   IDCANTON             CHAR(8)              not null,
   NOMBREPARROQUIA      CHAR(32)             null,
   constraint PK_PARROQUIA primary key (IDPARROQUIA)
);

/*==============================================================*/
/* Index: PARROQUIA_PK                                          */
/*==============================================================*/
create unique index PARROQUIA_PK on PARROQUIA (
IDPARROQUIA
);

/*==============================================================*/
/* Index: CANTONAPARROQUIA_FK                                   */
/*==============================================================*/
create  index CANTONAPARROQUIA_FK on PARROQUIA (
IDCANTON
);

/*==============================================================*/
/* Table: PROFESION                                             */
/*==============================================================*/
create table PROFESION (
   IDPROFESION          SERIAL                 not null,
   NOMBREPROFESION      VARCHAR(512)         null,
   constraint PK_PROFESION primary key (IDPROFESION)
);

/*==============================================================*/
/* Index: PROFESION_PK                                          */
/*==============================================================*/
create unique index PROFESION_PK on PROFESION (
IDPROFESION
);

/*==============================================================*/
/* Table: PROVINCIA                                             */
/*==============================================================*/
create table PROVINCIA (
   IDPROVINCIA          SERIAL              not null,
   NOMBREPROVINCIA      CHAR(32)             null,
   constraint PK_PROVINCIA primary key (IDPROVINCIA)
);

/*==============================================================*/
/* Index: PROVINCIA_PK                                          */
/*==============================================================*/
create unique index PROVINCIA_PK on PROVINCIA (
IDPROVINCIA
);

/*==============================================================*/
/* Table: SOLICITUD                                             */
/*==============================================================*/
create table SOLICITUD (
   IDSOLICITUD          SERIAL                 not null,
   CODIGOCLIENTE        INT8                 not null,
   FECHASOLICITUD       DATE                 null,
   FECHAPROCESADA       DATE                 null,
   ESTAPROCESADA        BOOL                 null,
   constraint PK_SOLICITUD primary key (IDSOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_PK                                          */
/*==============================================================*/
create unique index SOLICITUD_PK on SOLICITUD (
IDSOLICITUD
);

/*==============================================================*/
/* Index: CLIENTEASOLICITUD_FK                                  */
/*==============================================================*/
create  index CLIENTEASOLICITUD_FK on SOLICITUD (
CODIGOCLIENTE
);

/*==============================================================*/
/* Table: TARIFA                                                */
/*==============================================================*/
create table TARIFA (
   IDTARIFA             SERIAL                 not null,
   NOMBRETARIFA         VARCHAR(64)          null,
   ESFIJA               BOOL                 null,
   constraint PK_TARIFA primary key (IDTARIFA)
);

/*==============================================================*/
/* Index: TARIFA_PK                                             */
/*==============================================================*/
create unique index TARIFA_PK on TARIFA (
IDTARIFA
);

/*==============================================================*/
/* Table: TERRENO                                               */
/*==============================================================*/
create table TERRENO (
   IDTERRENO            SERIAL                 not null,
   IDCULTIVO            INT8                 not null,
   IDTARIFA             INT8                 not null,
   CODIGOCLIENTE        INT8                 not null,
   IDDERIVACION         INT8                 null,
   IDBARRIO             CHAR(8)              null,
   FECHACREACION        DATE                 null,
   CAUDAL               DECIMAL(9,2)         null,
   AREA                 DECIMAL(9,2)         null,
   constraint PK_TERRENO primary key (IDTERRENO)
);

/*==============================================================*/
/* Index: TERRENO_PK                                            */
/*==============================================================*/
create unique index TERRENO_PK on TERRENO (
IDTERRENO
);

/*==============================================================*/
/* Index: TERRENOACULTIVO_FK                                    */
/*==============================================================*/
create  index TERRENOACULTIVO_FK on TERRENO (
IDCULTIVO
);

/*==============================================================*/
/* Index: TARIFAATERRENO_FK                                     */
/*==============================================================*/
create  index TARIFAATERRENO_FK on TERRENO (
IDTARIFA
);

/*==============================================================*/
/* Index: CLIENTEATERRENO_FK                                    */
/*==============================================================*/
create  index CLIENTEATERRENO_FK on TERRENO (
CODIGOCLIENTE
);

/*==============================================================*/
/* Index: DERIVACIONATERRENO_FK                                 */
/*==============================================================*/
create  index DERIVACIONATERRENO_FK on TERRENO (
IDDERIVACION
);

/*==============================================================*/
/* Index: BARRIOATERRENO_FK                                     */
/*==============================================================*/
create  index BARRIOATERRENO_FK on TERRENO (
IDBARRIO
);

/*==============================================================*/
/* Table: TOMA                                                  */
/*==============================================================*/
create table TOMA (
   IDTOMA               SERIAL                 not null,
   IDCANAL              INT8                 not null,
   DESCRIPCIONTOMA      VARCHAR(64)          null,
   constraint PK_TOMA primary key (IDTOMA)
);

/*==============================================================*/
/* Index: TOMA_PK                                               */
/*==============================================================*/
create unique index TOMA_PK on TOMA (
IDTOMA
);

/*==============================================================*/
/* Index: CANALATOMA_FK                                         */
/*==============================================================*/
create  index CANALATOMA_FK on TOMA (
IDCANAL
);

alter table AREA
   add constraint FK_AREA_AREADETAR_TARIFA foreign key (IDTARIFA)
      references TARIFA (IDTARIFA)
      on delete restrict on update restrict;

alter table BARRIO
   add constraint FK_BARRIO_PARROQUIA_PARROQUI foreign key (IDPARROQUIA)
      references PARROQUIA (IDPARROQUIA)
      on delete restrict on update restrict;

alter table CALLE
   add constraint FK_CALLE_BARRIOACA_BARRIO foreign key (IDBARRIO)
      references BARRIO (IDBARRIO)
      on delete restrict on update restrict;

alter table CANTON
   add constraint FK_CANTON_PROVINCIA_PROVINCI foreign key (IDPROVINCIA)
      references PROVINCIA (IDPROVINCIA)
      on delete restrict on update restrict;

alter table CAUDAL
   add constraint FK_CAUDAL_CAUDALDET_TARIFA foreign key (IDTARIFA)
      references TARIFA (IDTARIFA)
      on delete restrict on update restrict;

alter table CLIENTE
   add constraint FK_CLIENTE_ACTIVIDAD_ACTIVIDA foreign key (IDACTIVIDAD)
      references ACTIVIDAD (IDACTIVIDAD)
      on delete restrict on update restrict;

alter table CLIENTE
   add constraint FK_CLIENTE_PROFESION_PROFESIO foreign key (IDPROFESION)
      references PROFESION (IDPROFESION)
      on delete restrict on update restrict;

alter table COBROAGUA
   add constraint FK_COBROAGU_TERRENOAC_TERRENO foreign key (IDTERRENO)
      references TERRENO (IDTERRENO)
      on delete restrict on update restrict;

alter table DERIVACION
   add constraint FK_DERIVACI_TOMAADERI_TOMA foreign key (IDTOMA)
      references TOMA (IDTOMA)
      on delete restrict on update restrict;

alter table EMPLEADO
   add constraint FK_EMPLEADO_CARGOAEMP_CARGO foreign key (IDCARGO)
      references CARGO (IDCARGO)
      on delete restrict on update restrict;

alter table PARROQUIA
   add constraint FK_PARROQUI_CANTONAPA_CANTON foreign key (IDCANTON)
      references CANTON (IDCANTON)
      on delete restrict on update restrict;

alter table SOLICITUD
   add constraint FK_SOLICITU_CLIENTEAS_CLIENTE foreign key (CODIGOCLIENTE)
      references CLIENTE (CODIGOCLIENTE)
      on delete restrict on update restrict;

alter table TERRENO
   add constraint FK_TERRENO_BARRIOATE_BARRIO foreign key (IDBARRIO)
      references BARRIO (IDBARRIO)
      on delete restrict on update restrict;

alter table TERRENO
   add constraint FK_TERRENO_CLIENTEAT_CLIENTE foreign key (CODIGOCLIENTE)
      references CLIENTE (CODIGOCLIENTE)
      on delete restrict on update restrict;

alter table TERRENO
   add constraint FK_TERRENO_DERIVACIO_DERIVACI foreign key (IDDERIVACION)
      references DERIVACION (IDDERIVACION)
      on delete restrict on update restrict;

alter table TERRENO
   add constraint FK_TERRENO_TARIFAATE_TARIFA foreign key (IDTARIFA)
      references TARIFA (IDTARIFA)
      on delete restrict on update restrict;

alter table TERRENO
   add constraint FK_TERRENO_TERRENOAC_CULTIVO foreign key (IDCULTIVO)
      references CULTIVO (IDCULTIVO)
      on delete restrict on update restrict;

alter table TOMA
   add constraint FK_TOMA_CANALATOM_CANAL foreign key (IDCANAL)
      references CANAL (IDCANAL)
      on delete restrict on update restrict;
