/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     9/23/2024 10:32:16 AM                        */
/*==============================================================*/


drop table if exists BOOKINGS;

drop table if exists CHATBOTCONVERSIONS;

drop table if exists CHATBOTLOGS;

drop table if exists CITY;

drop table if exists CONTACT;

drop table if exists DESTINATION;

drop table if exists DISTRICT;

drop table if exists FAQS;

drop table if exists REVIEWS;

drop table if exists TOUR;

drop table if exists TOURTYPE;

drop table if exists USERS;

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
   primary key (TOURID, USERID)
);

/*==============================================================*/
/* Table: CHATBOTCONVERSIONS                                    */
/*==============================================================*/
create table CHATBOTCONVERSIONS
(
   CHATID               int not null,
   USERID               int not null,
   MESSAGE              text not null,
   BOTRESPONSE          text not null,
   CONVERSATIONTIME     timestamp not null,
   primary key (CHATID)
);

/*==============================================================*/
/* Table: CHATBOTLOGS                                           */
/*==============================================================*/
create table CHATBOTLOGS
(
   LOGID                int not null,
   USERID               int not null,
   ACTION               varchar(255) not null,
   DETAILS              text not null,
   LOGDATE              timestamp not null,
   primary key (LOGID)
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
/* Table: FAQS                                                  */
/*==============================================================*/
create table FAQS
(
   FAQID                int not null,
   CHATID               int not null,
   QUESTION             text not null,
   ANSWER               text not null,
   primary key (FAQID)
);

/*==============================================================*/
/* Table: REVIEWS                                               */
/*==============================================================*/
create table REVIEWS
(
   REVIEWID             int not null,
   USERID               int not null,
   TOURID               int not null,
   RATING               int not null,
   COMMENT              text not null,
   POSTDATE             timestamp not null,
   primary key (REVIEWID)
);

/*==============================================================*/
/* Table: TOUR                                                  */
/*==============================================================*/
create table TOUR
(
   TOURID               int not null,
   TOURTYPEID           int not null,
   TOURNAME             varchar(255) not null,
   DESCRIPTION          text not null,
   PRICE                varchar(10) not null,
   TIME                 varchar(255) not null,
   IMAGE                longblob not null,
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
   NAME                 varchar(255) not null,
   EMAIL                varchar(255) not null,
   SDT                  varchar(10) not null,
   PASSWORD             varchar(255) not null,
   USERTYPE             varchar(255) not null,
   primary key (USERID)
);

alter table BOOKINGS add constraint FK_SE_CHON foreign key (USERID)
      references USERS (USERID) on delete restrict on update restrict;

alter table BOOKINGS add constraint FK_SE_DUOC foreign key (TOURID)
      references TOUR (TOURID) on delete restrict on update restrict;

alter table CHATBOTCONVERSIONS add constraint FK_SE foreign key (USERID)
      references USERS (USERID) on delete restrict on update restrict;

alter table CHATBOTLOGS add constraint FK_SE_XEM foreign key (USERID)
      references USERS (USERID) on delete restrict on update restrict;

alter table CONTACT add constraint FK_CO_THE foreign key (USERID)
      references USERS (USERID) on delete restrict on update restrict;

alter table DESTINATION add constraint FK_CHON foreign key (TOURID)
      references TOUR (TOURID) on delete restrict on update restrict;

alter table DESTINATION add constraint FK_SE_CO foreign key (DISTRICTID)
      references DISTRICT (DISTRICTID) on delete restrict on update restrict;

alter table DISTRICT add constraint FK_BAO_GOM foreign key (CITYID)
      references CITY (CITYID) on delete restrict on update restrict;

alter table FAQS add constraint FK_SE_DUOC_HUAN_LUYEN foreign key (CHATID)
      references CHATBOTCONVERSIONS (CHATID) on delete restrict on update restrict;

alter table REVIEWS add constraint FK_CO_QUYEN foreign key (USERID)
      references USERS (USERID) on delete restrict on update restrict;

alter table REVIEWS add constraint FK_TRONG foreign key (TOURID)
      references TOUR (TOURID) on delete restrict on update restrict;

alter table TOUR add constraint FK_THUOC foreign key (TOURTYPEID)
      references TOURTYPE (TOURTYPEID) on delete restrict on update restrict;

