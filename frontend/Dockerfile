FROM node:16-alpine3.16

ENV HOST = 0.0.0.0
ENV WORKDIR=/var/www/frontend

COPY package*.json ./

WORKDIR $WORKDIR

RUN npm install
RUN npm cache clean --force

COPY . .

EXPOSE 3000