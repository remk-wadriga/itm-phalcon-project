{% extends "templates/form.volt" %}

{% block fromFields %}

    {{ form('signin/login') }}

    <p>
        <label for="email">E-Mail</label>
        {{ text_field('email') }}
    </p>

    <p>
        <label for="password">Password</label>
        {{ password_field('password') }}
    </p>

    <p>
        {{ submit_button('Login') }}
    </p>

    {{ end_form() }}

{% endblock %}

