# Frog Templating with YAML

## Description

This plugin allows you to build pages using YAML. It is a simple way to create pages without having to write HTML. The plugin will parse the YAML and create the page for you.

## yaml example

```yaml
cdns:
scripts:
  - src: wp-content/themes/yastatheme/frog.js
  - inline: |
      console.log('frog!')
      var b = 5
      var c = 6
      console.log(b+c)
sections:
  - tag: section
    id: hero-section
    class: py-5 text-center
    style:
      background-color: lightgray
      padding: 20px
      margin: 0
      text-align: center
      color: red
    content:
      - tag: h1
        class: h1-title
        style:
          color: "#333"
          font-size: 2.5em
          margin: 0
        content: Welcome to our website
      - tag: h2
        style:
          color: green
          font-size: 1.5em
          margin: 0
        content: We are a team of professionals
      - tag: button
        link: /about
        class: btn btn-lg btn-primary
        content: Learn more
  - tag: section
    class: container py-5
    content:
      - tag: ol
        content:
          - tag: li
            content: Mercury
          - tag: li
            content: Saturn
          - tag: li
            content: Earth
      - tag: ul
        content:
          - tag: li
            content: Carrot
          - tag: li
            content: Banana
          - tag: li
            content: Apple

  - tag: section
    class: container py-5 text-center bg-light my-5
    content:
      - tag: a
        href: /about
        content:
          - tag: img
            class: img-fluid rounded-circle
            src: https://images.pexels.com/photos/1448316/pexels-photo-1448316.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1
            alt: This is an image alt text
            style:
              width: 200px
              height: auto
  - tag: section
    class: container
    content:
      - tag: p
        content: This is a paragraph
      - tag: table
        class: table table-striped
        id: my-table
        content:
          - tag: thead
            content:
              - tag: tr
                content:
                  - tag: th
                    content: Name
                  - tag: th
                    content: Age
          - tag: tbody
            content:
              - tag: tr
                content:
                  - tag: td
                    content: John Doe
                  - tag: td
                    content: 30
              - tag: tr
                content:
                  - tag: td
                    content: Jane Doe
                  - tag: td
                    content: 25
      - tag: button
        content: Click me
        class: btn btn-primary
        type: submit

  - tag: section
    class: container bg-light py-5
    id: form-id
    content:
      - tag: form
        action: "#"
        method: GET
        content:
          - tag: div
            class: form-group
            content:
              - tag: label
                content: Email
                class:
                for: input-email

              - tag: input
                name: email
                class: form-control
                placeholder: Enter your email

          - tag: div
            class: form-group
            content:
              - tag: label
                content: Password
                class:
                for: input-password

              - tag: input
                class: form-control
                name: password
                placeholder: Enter your password
          - tag: button
            type: submit
            class: btn btn-primary
            content: Send
```
