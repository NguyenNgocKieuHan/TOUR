/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     10/1/2024 6:25:46 PM                         */
/*==============================================================*/


drop table if exists ADMIN;

drop table if exists BOOKINGS;

drop table if exists CITY;

drop table if exists CONTACT;

drop table if exists DESTINATION;

drop table if exists DISTRICT;

drop table if exists REVIEWS;

drop table if exists TOUR;

drop table if exists TOURTYPE;

drop table if exists USERS;

/*==============================================================*/
/* Table: ADMIN                                                 */
/*==============================================================*/
create table ADMIN
(
   ADID                 int not null,
   ADNAME               varchar(255) not null,
   ADEMAIL              varchar(255) not null,
   ADSDT                varchar(10) not null,
   ADPASSWORD           varchar(255) not null,
   primary key (ADID)
);

/*==============================================================*/
/* Table: BOOKINGS                                              */
/*==============================================================*/
create table BOOKINGS
(
   TOURID               int not null,
   USERID               int not null,
   BOOKINGDATE          timestamp not null,
   NUMOFPEOPLE          int not null,
   TOTALPRICE           decimal not null,
   STATUS               int not null,
   STARTDATE            date not null,
   CANCELLED_BY         int not null,
   REJECTION_REASON     text not null,
   primary key (TOURID, USERID)
);

/*==============================================================*/
/* Table: CITY                                                  */
/*==============================================================*/
create table CITY
(
   CITYID               int not null,
   CITYNAME             varchar(255) not null,
   primary key (CITYID)
);

/*==============================================================*/
/* Table: CONTACT                                               */
/*==============================================================*/
create table CONTACT
(
   CONTACTID            int not null,
   USERID               int not null,
   MESSAGE              text not null,
   CONTACTDATE          timestamp not null,
   primary key (CONTACTID)
);

/*==============================================================*/
/* Table: DESTINATION                                           */
/*==============================================================*/
create table DESTINATION
(
   DESTINATIONID        int not null,
   DISTRICTID           int not null,
   TOURID               int not null,
   DESTINATIONNAME      varchar(255) not null,
   IMAGE                longblob not null,
   primary key (DESTINATIONID)
);

/*==============================================================*/
/* Table: DISTRICT                                              */
/*==============================================================*/
create table DISTRICT
(
   DISTRICTID           int not null,
   CITYID               int not null,
   DISTRICTNAME         varchar(255) not null,
   primary key (DISTRICTID)
);

/*==============================================================*/
/* Table: REVIEWS                                               */
/*==============================================================*/
create table REVIEWS
(
   TOURID               int not null,
   USERID               int not null,
   RATING               int not null,
   COMMENT              text not null,
   POSTDATE             timestamp not null,
   REVIEWIMAGE          longblob not null,
   primary key (TOURID, USERID)
);

/*==============================================================*/
/* Table: TOUR                                                  */
/*==============================================================*/
create table TOUR
(
   TOURID               int not null,
   TOURTYPEID           int not null,
   ADID                 int not null,
   TOURNAME             varchar(255) not null,
   DESCRIPTION          text not null,
   PRICE                varchar(10) not null,
   TIME                 varchar(255) not null,
   IMAGE                longblob not null,
   MAXSLOTS             int not null,
   primary key (TOURID)
);

/*==============================================================*/
/* Table: TOURTYPE                                              */
/*==============================================================*/
create table TOURTYPE
(
   TOURTYPEID           int not null,
   TOURTYPENAME         varchar(255) not null,
   DESCRIPTION          text not null,
   primary key (TOURTYPEID)
);

/*==============================================================*/
/* Table: USERS                                                 */
/*==============================================================*/
create table USERS
(
   USERID               int not null,
   USNAME               varchar(255) not null,
   USEMAIL              varchar(255) not null,
   USSDT                varchar(10) not null,
   USPASSWORD           varchar(255) not null,
   primary key (USERID)
);

alter table BOOKINGS add constraint FK_SE_CHON foreign key (USERID)
      references USERS (USERID) on delete restrict on update restrict;

alter table BOOKINGS add constraint FK_SE_DUOC foreign key (TOURID)
      references TOUR (TOURID) on delete restrict on update restrict;

alter table CONTACT add constraint FK_CO_THE foreign key (USERID)
      references USERS (USERID) on delete restrict on update restrict;

alter table DESTINATION add constraint FK_CHON foreign key (TOURID)
      references TOUR (TOURID) on delete restrict on update restrict;

alter table DESTINATION add constraint FK_SE_CO foreign key (DISTRICTID)
      references DISTRICT (DISTRICTID) on delete restrict on update restrict;

alter table DISTRICT add constraint FK_BAO_GOM foreign key (CITYID)
      references CITY (CITYID) on delete restrict on update restrict;

alter table REVIEWS add constraint FK_CO_QUYEN foreign key (USERID)
      references USERS (USERID) on delete restrict on update restrict;

alter table REVIEWS add constraint FK_TRONG foreign key (TOURID)
      references TOUR (TOURID) on delete restrict on update restrict;

alter table TOUR add constraint FK_THUOC foreign key (TOURTYPEID)
      references TOURTYPE (TOURTYPEID) on delete restrict on update restrict;

alter table TOUR add constraint FK__A_THEM foreign key (ADID)
      references ADMIN (ADID) on delete restrict on update restrict;

