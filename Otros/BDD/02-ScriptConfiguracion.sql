/*------CONFIGURACION PISQUE-----------*/


/*==============================================================*/
/* CONFIGURACION                                                */
/*==============================================================*/

insert into configuracion (id,nombrejunta,logojunta,estaenproduccion,constante) values
(1,'PISQUE',null,false,0.8);


/*==============================================================*/
/* SECTORES                                                     */
/*==============================================================*/

insert into provincia (nombreprovincia) values ('Pichincha');
insert into canton(idprovincia,nombrecanton) values (1,'Cayambe');
insert into parroquia (idcanton,nombreparroquia) values (1,'Pisque');

insert into barrio (idparroquia,nombrebarrio) values (1,'Junta Modular 1');
insert into barrio (idparroquia,nombrebarrio) values (1,'Junta Modular 2');
insert into barrio (idparroquia,nombrebarrio) values (1,'Junta Modular 3');
insert into barrio (idparroquia,nombrebarrio) values (1,'Junta Modular 4');
insert into barrio (idparroquia,nombrebarrio) values (1,'Junta Modular 5');
insert into barrio (idparroquia,nombrebarrio) values (1,'Junta Modular 6');


/*==============================================================*/
/* TOMAS                                                        */
/*==============================================================*/

insert into canal (descripcioncanal) values('norte');
insert into toma (idcanal,idbarrio,descripciontoma) values(1,1,'Toma 1');
insert into toma (idcanal,idbarrio,descripciontoma) values(1,1,'Toma 2');
insert into derivacion (idtoma,descripcionderivacion) values(1,'derivacion 1');

insert into canal (descripcioncanal) values('sur');
insert into toma (idcanal,idbarrio,descripciontoma) values(2,2,'Toma 3');
insert into toma (idcanal,idbarrio,descripciontoma) values(2,2,'Toma 4');
insert into derivacion (idtoma,descripcionderivacion) values(3,'derivacion 2');

insert into canal (descripcioncanal) values('centro');
insert into toma (idcanal,idbarrio,descripciontoma) values(3,3,'Toma 5');
insert into toma (idcanal,idbarrio,descripciontoma) values(3,3,'Toma 6');
insert into derivacion (idtoma,descripcionderivacion) values(5,'derivacion 3');



/*==============================================================*/
/* TARIFAS                                                      */
/*==============================================================*/

/*-------------------Ingreso tarifas------------------------*/	  
insert into tarifa (aniotarifa,nombretarifa) values('2015','Ciclo Corto');
insert into tarifa (aniotarifa,nombretarifa) values('2015','Floricultura');
insert into tarifa (aniotarifa,nombretarifa) values('2015','Cooperativas y escuelas');



/*Ingreso Area ciclo corto*/
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(1,2015,0.00,0.25,22.00,true,null);
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(1,2015,0.25,0.50,23.10,true,null);
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(1,2015,0.05,0.75,24.20,true,null);
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(1,2015,0.75,1.00,26.40,true,null);
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(1,2015,1.00,2.50,28.60,false,null);
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(1,2015,2.50,5.00,33.00,false,null);
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(1,2015,5.00,7.50,37.40,false,null);
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(1,2015,7.50,10.00,41.80,false,null);
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(1,2015,10.00,9999,88.00,false,null);

/*Ingreso Area Floricultura*/
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(2,2015,0.00,9999,151.80,false,null);

/*Ingreso Area Cooperativas y escuelas*/
insert into area (idtarifa,aniotarifa,desde,hasta,costo,esfija,observacion) values(3,2015,0.00,9999,39.60,false,null);

/*Ingreso Caudal ciclo corto*/
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(1,2015,0.00,0.20);
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(1,2015,0.20,0.40);
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(1,2015,0.40,0.60);
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(1,2015,0.60,0.80);
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(1,2015,0.80,2.00);
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(1,2015,2.00,4.00);
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(1,2015,4.00,6.00);
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(1,2015,6.00,8.00);
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(1,2015,8.00,9999);

/*Ingreso Caudal floricultura*/
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(2,2015,0.00,9999);

/*Ingreso Caudal Cooperativas y escuelas*/
insert into caudal (idtarifa,aniotarifa,desde,hasta) values(3,2015,0.00,9999);


/*==============================================================*/
/* DESCUENTOS                                                   */
/*==============================================================*/

insert into descuento (year, mes,porcentaje) values (2015,01,0.6);
insert into descuento (year, mes,porcentaje) values (2015,02,0.5);
insert into descuento (year, mes,porcentaje) values (2015,03,0.4);
insert into descuento (year, mes,porcentaje) values (2015,04,0.3);
insert into descuento (year, mes,porcentaje) values (2015,05,0.2);
insert into descuento (year, mes,porcentaje) values (2015,06,0.1);

