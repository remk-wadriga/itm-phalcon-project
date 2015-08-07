{% extends "templates/form.volt" %}

{% block fromFields %}

    {{ form('signup/register') }}

    <p>
        <label for="email">E-Mail</label>
        {{ text_field('email') }}
    </p>

    <p>
        <label for="first_name">First name</label>
        {{ text_field('first_name') }}
    </p>

    <p>
        <label for="last_name">Last name</label>
        {{ text_field('last_name') }}
    </p>

    <p>
        <label for="phone">Phone</label>
        {{ text_field('phone') }}
    </p>

    <p>
        <label for="password">Password</label>
        {{ password_field('password') }}
    </p>

    <p>
        <label for="retype_password">Retype password</label>
        {{ password_field('retype_password') }}
    </p>

    <p>
        {{ submit_button('Register') }}
    </p>

    {{ end_form() }}

{% endblock %}

