"use strict";
require("dotenv").config();
const routes = require('./routes.js');
const auth = require('./auth.js');
const express = require("express");
const myDB = require("./connection");
const fccTesting = require("./freeCodeCamp/fcctesting.js");
const app = express();
require('dotenv').config();

let session = require("express-session");
let passport = require("passport");

let ObjectId = require("mongodb");
let mongo = require("mongodb").MongoClient;
const LocalStrategy = require('passport-local');
const bcrypt = require('bcrypt');
const http = require('http').createServer(app);
const io = require('socket.io')(http);
const passportSocketIo = require('passport.socketio');
const cookieParser = require("cookie-parser");
const MongoStore = require('connect-mongo')(session);
const URI = process.env.MONGO_URI;
const store = new MongoStore({url:URI});

app.use(session({
  secret: process.env.SESSION_SECRET,
  resave: true,
  saveUninitialized: true,
  cookie: { secure: false },
  key: 'connect.sid',
  store: store
}));
app.use(passport.initialize());
app.use(passport.session());




fccTesting(app); //For FCC testing purposes
app.use("/public", express.static(process.cwd() + "/public"));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.set("view engine", "pug");
app.set("views", "./views/pug");
io.use(
  passportSocketIo.authorize({
    cookieParser: cookieParser,
    key: 'connect.sid',
    secret: process.env.SESSION_SECRET,
    store: store,
    success: onAuthorizeSuccess,
    fail: onAuthorizeFail
  })
);
myDB(async (client) => {
  const myDataBase = await client.db("cluster0").collection("users");
    routes(app,myDataBase);
    auth(app,myDataBase);
    let currentUsers = 0;
    io.on('connection',socket=>{
        console.log(` user `+socket.request.user.name+` connected`);
            io.emit('user count',currentUsers);

        currentUsers++;
        socket.on('chat message',message=>{
            io.emit('chat message',{name:socket.request.user.name,message})
        })
        io.emit('user',{
            name:socket.request.user.name,
            currentUsers,
            connected:true
        });
    socket.on('disconnect',()=>{
        console.log("A user disconnected");
        currentUsers--;
        io.emit('user count',currentUsers);
    });
    });
 
 }) .catch(e => {
  app.route("/").get((req, res) => {
    res.render("pug", { title: e, message: "Unable to login" });
  });
});

function onAuthorizeSuccess(data, accept) {
  console.log('successful connection to socket.io');
  accept(null, true);
}

function onAuthorizeFail(data, message, error, accept) {
  if (error) throw new Error(message);
  console.log('failed connection to socket.io:', message);
  accept(null, false);
}

http.listen(process.env.PORT || 3000, () => {
  console.log("Listening on port " + process.env.PORT);
});
