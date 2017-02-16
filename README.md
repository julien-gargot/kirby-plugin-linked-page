# Kirby linked-page plugin

Try to “syncronize” relations between pages so you can edit a relation on each linked pages.

## Requirement and Settings

You must designate field that is used to link pages between them.
```
c::set('linked.pages.field','relatedPages');
```

If you want to use multiple linked field or a different field name in each blueprint, use:
```
c::set('linked.pages.field','use.convention');
```
and named your fields following this convention:
(related**template**s. Template’s name with an “s”.)
```
relatedTemplates:
  extends: linkedPage
```
For example, if you have a *Project* template that you want to connect to a *Event* template, you should have:
```
# site/blueprints/project.php
relatedEvents:
  extends: linkedPage

# site/blueprints/event.php
relatedProjects:
  extends: linkedPage
```

## Options

They are two modes for “saving” relations on page update.
`c::set('linked.pages.mode','normal')` (default) and `c::set('linked.pages.mode','force.creation');`

1. The `normal` mode saves information if a change is detected in the page you are editing.
It’s the mode that uses fewer resources, but it’s easy to lose connection between pages if you edit them outside the panel.
2. The `force.creation` mode (re)saves connection(s) each times you update the page. It will reasonably prevent losing connections.

## Important

This is a very experimental plugin, use it for your own tests. I advise you not to build a website that depends on it.
It’s better to use the plugin from the beginning of your project, because relations are built on page creation and update, but there is nothing to automatically build relations through existing contents.
