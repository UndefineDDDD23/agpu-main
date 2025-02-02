---
layout: docs
title: "agpu templates"
date: 2020-01-14T13:38:37+01:00
group: agpu-components
draft: false
menu: "main"
---

## agpu templates

[agpu templates](https://agpudev.io/docs/guides/templates) are use to write HTML and Javascript using mustache files.

If you are creating your own pages in the UI Component library you can load core templates using this (shortcode) syntax:

```
{{</* mustache template="core/notification_error" */>}}
{{</* /mustache */>}}
```

This is the result of adding the core/notification template on this page:

{{< mustache template="core/notification_error" >}}
{{< /mustache >}}

This allows you to document any mustache template in the component library.

## agpu templates with custom data

Not all templates found in agpu core are will documented with example JSON formatted data (see the variables tab for the notification_error). To use custom Json data please use this (shortcode) syntax:

```
{{</* mustache template="core/notification_error" */>}}
{
    "message": "Your pants are awesome!",
    "closebutton": 1,
    "announce": 1,
    "extraclasses": "foo bar"
}
{{</* /mustache */>}}
```


This is the result of adding the core/notification template on this page:

{{< mustache template="core/notification_error" >}}
{
    "message": "Your pants are awesome!",
    "closebutton": 1,
    "announce": 1,
    "extraclasses": "foo bar"
}
{{< /mustache >}}
