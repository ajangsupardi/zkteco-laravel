<?php

namespace Rynest\Zkteco;

class Const
{
    const CMD_CONNECT = 1000;
    const CMD_EXIT = 1001;
    const CMD_ACK_OK = 1002;
    const CMD_ACK_ERROR = 1003;
    const CMD_ACK_UNKNOWN = 1004;
    const CMD_ACK_UNAUTH = 1005;
    const CMD_ENABLEDEVICE = 1006;
    const CMD_DISABLEDEVICE = 1007;
    const CMD_GET_VERSION = 1008;
    const CMD_OPTIONS_RRQ = 1009;
    const CMD_OPTIONS_WRQ = 1010;
    const CMD_GET_FREE_SIZES = 1011;
    const CMD_USERTEMP_RRQ = 1012;
    const CMD_USERTEMP_WRQ = 1013;
    const CMD_USERTEMP_RPL = 1014;
    const CMD_USERTEMP_DEL = 1015;
    const CMD_DELETE_USER = 1016;
    const CMD_ENABLE_QUERIES = 1017;
    const CMD_USER_WRQ = 1018;
    const CMD_USER_RRQ = 1019;
    const CMD_CLEAR_ADMIN = 1020;
    const CMD_CLEAR_DATA = 1021;
    const CMD_FREE_DATA = 1022;
    const CMD_RESTART = 1023;
    const CMD_POWEROFF = 1024;
    const CMD_REBOOT = 1025;
    const CMD_POWERUP = 1026;
    const CMD_SET_USER_TEMPLATE = 1027;
    const CMD_GET_USER_TEMPLATE = 1028;
    const CMD_GET_USERS = 1014; // alias
    const CMD_GET_ATTENDANCE = 1020; // placeholder
}
