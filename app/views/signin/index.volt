{% extends "templates/main.volt" %}

{% block title %}Signin{% endblock %}

{% block content %}

    <h2>Sign in using this form</h2>

    {{ partial('signin/_form') }}

{% endblock %}