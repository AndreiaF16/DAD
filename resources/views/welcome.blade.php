<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Virtual Wallet</title>
    </head>
    <body>
        <div class="container" id="app">
            <router-link to="/login"> Login </router-link>
            <router-link to="/home"> Home </router-link>
            <button v-if="!isLoggedIn()">teste</button>
            <button @click="logout" v-if="isLoggedIn()">Logout</button>
            <em>User: @{{this.$store.state.user != null ? this.$store.state.user.data.name : " ** No User Logged in ** " }}</em>
            <router-view></router-view>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>
