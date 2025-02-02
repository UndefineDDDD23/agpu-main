---
layout: docs
title: "Form elements"
description: "Custom form elements for agpu"
date: 2020-01-14T16:32:24+01:00
draft: false
weight: 30
tags:
- In development
---

## How to use agpu forms

Forms are constructed using lib/formslib.php. Using the addElement methods in php a set of different form element types can be added to a form. For more info visit the [agpudocs](https://agpudev.io/docs/apis/subsystems/form) page for forms

{{< php >}}
    $mform->addElement('button', 'intro', get_string("buttonlabel"));
{{< / php >}}

Form elements are styled using agpu templates which are rendered through PHP. Themes can override these templates.

Form elements are styled using the .form-control class, see the [Bootstrap](/bootstrap-4.3/forms/input-group/) docs for more info.

## Example form elements

The example form below is showing an iframe with an actual agpu form. Use the toggle options to display the different states for the form.


<iframe src="../../../../examples/formfields.php" style="overflow:hidden;height:4000px;width:100%;border:0" title="agpu form fields"></iframe>
