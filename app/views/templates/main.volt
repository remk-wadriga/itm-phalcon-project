<!DOCTYPE html>
<html lang="en">

<head>
    {{ assetManager.displayScc('main') }}
    {{ assetManager.displayFonts('main') }}

    {% block head %}{% endblock %}

    <title>{% block title %}{% endblock %}</title>

</head>

<body>
    <div id="main_wrapper">

        <div class="row show-grid" id="header_wrapper">
            {% block header %}
                {{ partial('templates/_header') }}
            {% endblock %}
        </div>

        <div class="row show-grid" id="content_wrapper">

            <div class="col-md-3" id="left_menu">
                {% block leftMenu %}
                    {{ widget.run('accordion') }}
                {% endblock %}
            </div>

            <div class="col-md-9" id="content">
                {% block content %}{% endblock %}
            </div>

        </div>

        <div class="row show-grid" id="footer_wrapper">
            {% block footer %}
                {{ partial('templates/_footer') }}
            {% endblock %}
        </div>

    </div>

    {{ assetManager.displayJs('main') }}
    {{ assetManager.displayScripts('main') }}

    {{ partial('templates/_init-javasripts') }}
</body>

</html>