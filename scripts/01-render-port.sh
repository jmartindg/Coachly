#!/bin/bash
# Make nginx listen on Render's PORT (default 10000)
if [ -n "$PORT" ]; then
    sed -i "s/listen 10000;/listen ${PORT};/" /etc/nginx/sites-available/default.conf
fi
