{% extends "templates/main.volt" %}

{% block title %}Signup{% endblock %}

{% block content %}

    <h2>Sign up using this form</h2>

    {{ partial('signup/_form') }}

{% endblock %}