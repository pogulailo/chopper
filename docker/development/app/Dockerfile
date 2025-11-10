FROM php:8.4-fpm

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
        ca-certificates curl gnupg dirmngr \
        xvfb mesa-utils libglu1-mesa \
        prusa-slicer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /home/app/web
