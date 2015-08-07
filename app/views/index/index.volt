
{% extends "templates/main.volt" %}

{% block title %}Hello world page{% endblock %}

{% block content %}

    Hello {{name}}!
    {{link_to('signin', 'Login')}}
    <br />
    {{link_to('signup', 'Sighup')}}

{% endblock %}