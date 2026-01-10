<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* Sticky footer styles */
        html {
            height: 100%;
        }

        body {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            margin-top: 50px;
        }

        footer {
            margin-top: auto !important;
        }

        .hero-section {
            background-image: url('https://placehold.co/1920x600/2f3842/ffffff?text=FoodFusion');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        @media (max-width: 768px) {
            .hero-section {
                background-image: url('https://placehold.co/768x1024/2f3842/ffffff?text=FoodFusion');
                background-size: cover;
                background-position: center;
            }
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .profile-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            overflow: hidden;
        }

        .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background-color: #6c757d;
            color: white;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>