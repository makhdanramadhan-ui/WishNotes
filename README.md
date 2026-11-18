# WishNotes

WishNotes is a Laravel web app for creating themed message boards. On the Christmas tree board, visitors choose an ornament, place it on the tree, and attach a note. The project was built as a group assignment for Semester 3 Web Programming.

## My contribution

I worked on both sides of the app: the PHP/Laravel backend and the Blade frontend. I connected the board interface to the backend so the app could store a note along with its ornament position and draw it in the same spot when the board was reopened.

## How it works

In the later coursework build, signed-in users create a board with a title and description, choose a Christmas tree, bulletin board, or mailbox layout, and set its visibility. The dashboard lists their boards and shows the message count for each. On the tree, visitors can choose from five ornament designs and leave the name field blank to post without a display name.

The app uses PHP and Laravel for the backend, Blade and JavaScript for the interface, and SQLite for boards and messages.

## Repository and screenshots

This repository contains an early snapshot with registration, sign-in, a dashboard, and a Christmas tree view. The [portfolio case study](https://makhdanramadhan-ui.github.io/projects.html#wishnote) shows the later local build, including the dashboard and tree board with sample data. The prototype has incomplete privacy and authorization checks and is not intended for public deployment.
