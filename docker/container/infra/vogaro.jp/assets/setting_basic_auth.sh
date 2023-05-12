#!/bin/sh
htpasswd -c -b /var/htpasswd/$VIRTUAL_HOST $AUTH_ID $AUTH_PW