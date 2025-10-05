/* @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@300;400;500;600;700&display=swap'); */
@import url('https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap');

* {
    font-family: "Public Sans", sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    /* Main font */
}

body {
    background-color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

/* //////////////////////////////////////////////// */

.login-wrap {
    width: 100%;
    min-height: 100vh;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    flex-wrap: wrap;
    justify-content: right;
    align-items: center;
    /* padding: 15px; */
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    position: relative;
    z-index: 1;
}

.login-wrap::before {
    content: "";
    display: block;
    position: absolute;
    z-index: -1;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: #e7f1ff;
}

.login-card {
    position: absolute;
    width: 100%;
    /* padding: 20px; */
    /* border-radius: 10px; */
    /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */

    /* box-shadow: 3px 5px 11px #333; */
    padding-top: 35px;
    padding-left: 35px;
    padding-right: 35px;
    height: 100%;
    width: 35%;
    /* border-radius: 6%; */
    overflow: hidden;
    background: #a5c8fb;
    /* display: flex; */
    justify-content: center;
    align-items: top;
}

.login100-form-left-background {
    position: absolute;
    width: 70%;
    height: 100%;
    top: 0;
    left: 0;
    padding: 0;
}


.pharmacy {
    /* margin-top: 10px;
    margin-right: 5px;
    border-radius: 50%; */
    /* border: solid 1px #181347; */
    height: 80%;
    width: 93%;
    opacity: 85%;
    margin-top: 38px;

    justify-content: left;
    align-items: left;
    top: 0;
    margin-left: -25px;
    object-fit: cover;
    flex-wrap: wrap;
}

.login100-form-logo {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 127px;
    height: 172px;
    margin: 0 auto 1px auto;
    padding: 20px;
}

.brindox {
    margin-top: 50px;
    margin-right: 5px;
    border-radius: 50%;
    /* border: solid 1px #181347; */
    height: 160px;
    width: 160px;
    object-fit: cover;
    flex-wrap: wrap;
}



.login100-form-title {
    font-family: "Public Sans", sans-serif;
    /* Fallback font */
    font-size: 32px;
    color: #003984;
    line-height: 2;
    text-align: center;
    text-transform: uppercase;
    display: block;
    margin-top: 10px;
    margin-bottom: 60px;
    letter-spacing: 2px;
    font-weight: 900;
}

h5 {
    margin-left: 40%;
    padding-bottom: 15px;
    outline: 0;
    align-items: center;
    -moz-outline-style: none;
    font-family: "Public Sans", sans-serif;
    /* Main font */
    margin-top: 105px;
}

a {
    color: #003984;
    text-decoration: none;
}

.form {
    align-items: center;
    padding-top: 10px;

    input[type="text"],
    input[type="password"],
    button {
        /* margin-left: 25%; */
        margin-bottom: 11px;
        border-radius: 10px;
        outline: 0;
        -moz-outline-style: none;
        font-family: "Public Sans", sans-serif;
        /* Main font */
    }

    .txt1 {
        position: absolute;
        top: 50.9%;
        transform: translateY(-50%);
        cursor: pointer;
        margin-top: 10%;
        padding-bottom: 14px;
        outline: 0;
        -moz-outline-style: none;
        font-family: "Public Sans", sans-serif;
    }

    .txt2 {
        position: absolute;
        bottom: 200px;
        width: 100%;
        right: 0px;
        text-align: center;
    }

    .txt3 {
        position: absolute;
        bottom: 25px;
        left: 70px;
        width: 95%;
        text-align: left;
    }

    .txt4 {
        position: absolute;
        bottom: 35px;
        left: 70px;
        text-align: right;
        width: 95%;
        background: none;
        border: none;
        text-decoration: none;
        box-shadow: none;
    }

    .txt1,
    .txt2 {
        color: #003984;
        font-size: 20px;
        font-weight: 300;
        font-family: "Public Sans", sans-serif;
        text-decoration: none;
        /* letter-spacing: .5px; */
    }

    .txt3,
    .txt4 {
        color: #003984;
        font-size: 16px;
        font-weight: 300;
        font-family: "Public Sans", sans-serif;
        text-decoration: none;
    }

    .bottom-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0px;
        /* Adjust the gap between columns as needed */
        align-items: center;
    }

    #username {
        padding: 0 55px 0 63px;
        color: #003984;
        font-weight: 300;
    }

    #verify_code {
        padding: 0 55px 0 63px;
        color: #003984;
        font-weight: 300;
    }

    input[type="password"] {
        color: #003984;
        padding: 0 55px 0 63px;
        font-weight: 300;
    }


    input[type="text"] {
        padding: 0 55px 0 63px;
        color: #003984;
        font-weight: 300;
    }

    #username::placeholder,
    #verify_code::placeholder,
    #code::placeholder,
    #password::placeholder,
    #email::placeholder,
    #newpass::placeholder,
    #verifypass::placeholder {
        color: #003984;
        font-size: 21px;
        font-weight: 300;
        font-family: "Public Sans", sans-serif;
    }

    input[type="text"],
    input[type="password"] {
        border: 1px solid #bbb;
        font-size: 21px;
        font-family: "Public Sans", sans-serif;
        /* Main font */
        height: 50px;
        letter-spacing: 1px;
        width: 100%;
        background-color: #c8d4fc;
        border-radius: 0;

        &:focus {
            border: 1px solid #3498db;
        }
    }

    #container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0px;
        /* Adjust the gap between columns as needed */
        align-items: center;
        /* Vertically align items in the center */
    }

    #container h5 {
        margin: 0;
        font-size: 14px;
    }


    a {
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: #3498db;

        p {
            padding-bottom: 10px;
        }


    }

    #toggler {
        position: absolute;
        right: 10%;
        top: 51.8%;
        font-size: 20px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #254263;
    }

    #account {
        position: absolute;
        left: 7.5%;
        top: 44.7%;
        font-size: 28px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #e4e4e4;
        border-color: #052d5a;
        border-right: solid 2px #4c86c9;
        padding-right: 6px;
        padding-left: 2px;
        height: 48px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 35px;
    }

    #lock {
        position: absolute;
        left: 7.5%;
        top: 51.8%;
        font-size: 28px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #e4e4e4;
        border-color: #052d5a;
        border-right: solid 2px #4c86c9;
        padding-right: 6px;
        padding-left: 2px;
        height: 48px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 35px;
    }

    #email {
        position: absolute;
        left: 5.5%;
        top: 44.7%;
        font-size: 28px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #e4e4e4;
        border-color: #052d5a;
        border-right: solid 2px #3d6797;
        padding-right: 6px;
        padding-left: 6px;
        height: 48px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 35px;
    }


    .password-container #toggler2 {
        position: absolute;
        right: 7.9%;
        top: 51.8%;
        font-size: 20px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #254263;
    }

    .password-container #toggler1 {
        position: absolute;
        right: 8%;
        top: 44.7%;
        font-size: 20px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #254263;
    }

    button {
        background: #003984;
        border: none;
        border-radius: 50px;
        color: #fff;
        font-size: 19px;
        font-weight: 300;
        /* cursor: pointer; */
        transition: box-shadow .4s ease;
        box-shadow: 1px 3px 8px #222;
        text-transform: uppercase;
        width: 100%;
        height: 50px;
        margin-top: 5%;
        /* margin-left: 0%; */
        display: flex;
        justify-content: center;
        align-items: center;

        letter-spacing: 1px;

        &:hover {
            box-shadow: 1px 1px 7px rgb(1, 85, 1);
        }

        &:active {
            box-shadow: 1px 2px 7px #222;
        }

    }

}


/* ///////////////////////////////////////////////////////////////////////////////// */

/* Message Box Styling */
.message-box {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 300px;
    padding: 20px;
    background-color: #f1f1f1;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 1000;
    display: none;
}

#error_msg {
    color: #024ab8;
    margin-bottom: 10px;
    /* Space between message and progress bar */
    font-size: 16px;
    /* Dark gray text */
    font-weight: 300;
    font-family: "Public Sans", sans-serif;
    /* Main font */
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
}


/* Close Button Styling */
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    font-weight: 300;
}

/* Loading Bar Styling */
.loading-bar-container {
    position: relative;
    width: 100%;
    height: 5px;
    background-color: #ddd;
    margin-top: 20px;
}

.loading-bar {
    position: absolute;
    height: 100%;
    width: 100%;
    background-color: #007bff;
    animation: load 10s linear forwards;
}

@keyframes load {
    from {
        width: 100%;
    }

    to {
        width: 0;
    }
}



/* //////////////////////////////////////////////////////////// */




@media (max-width: 1238px) {

    .login-wrap {
        width: 100%;
        background: #e7f1ff;
        /* z-index: -1; */
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }

    .login-card {
        /* width: 90%; */
        box-shadow: 1px 3px 17px #3498db;
        border-radius: 70px 70px 0 0;
        flex: 1 1 100%;
        bottom: 0;
        width: 100%;
        height: 530px;
    }


    .login100-form-left-background {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        right: 0;
        padding: 0;
    }


    .pharmacy {
        /* margin-top: 10px;
        margin-right: 5px;
        border-radius: 50%; */
        /* border: solid 1px #181347; */
        height: 300px;
        width: 100%;
        opacity: 85%;
        padding: 10px;

        /* justify-content: top;
        align-items: top; */
        right: 0;
        margin-left: -2px;
        object-fit: cover;
        flex-wrap: wrap;
    }

    .login100-form-logo {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 87px;
        height: 82px;
        margin: 0 auto 1px auto;
        padding: 10px;
    }


    .brindox {
        margin: 10px;
        border-radius: 50%;
        /* border: solid 1px #181347; */
        height: 120px;
        width: 120px;
        object-fit: cover;
        flex-wrap: wrap;
    }



    .login100-form-title {
        font-family: "Public Sans", sans-serif;
        /* Fallback font */
        font-size: 28px;
        color: #003984;
        line-height: 2;
        text-align: center;
        text-transform: uppercase;
        display: block;
        margin: 10px;
        letter-spacing: 2px;
        font-weight: 900;
    }

    h5 {
        /* margin-left: 40%; */
        /* padding-bottom: 100px; */
        outline: 0;
        align-items: baseline;
        -moz-outline-style: none;
        font-family: "Public Sans", sans-serif;
        /* Main font */
        margin-top: 145px;
        /* bottom: 0; */
        text-align: top;
    }

    a {
        color: #003984;
        text-decoration: none;
    }


    .form {
        /* align-items: center; */
        padding-top: 31px;

        input[type="text"],
        input[type="password"],
        button {
            /* margin-left: 25%; */
            /* margin-bottom: 11px; */
            border-radius: 10px;
            outline: 0;
            -moz-outline-style: none;
            font-family: "Public Sans", sans-serif;
            /* Main font */
        }

        .txt1 {
            position: absolute;
            top: 26%;
            transform: translateY(-50%);
            cursor: pointer;
            margin-top: 32%;
            padding-bottom: 21px;
            font-size: 12px;
            outline: 0;
            -moz-outline-style: none;
            font-family: "Public Sans", sans-serif;
        }

        .txt2 {
            position: absolute;
            bottom: 30px;
            width: 100%;
            right: 0px;
            text-align: center;
        }

        .txt3 {
            position: absolute;
            bottom: 25px;
            left: 70px;
            width: 95%;
            text-align: left;
        }

        .txt4 {
            position: absolute;
            bottom: 35px;
            left: 70px;
            text-align: right;
            width: 95%;
            background: none;
            border: none;
            text-decoration: none;
            box-shadow: none;
        }

        .txt1,
        .txt2 {
            color: #003984;
            font-size: 20px;
            font-weight: 300;
            font-family: "Public Sans", sans-serif;
            text-decoration: none;
            /* letter-spacing: .5px; */
        }

        .txt3,
        .txt4 {
            color: #003984;
            font-size: 16px;
            font-weight: 300;
            font-family: "Public Sans", sans-serif;
            text-decoration: none;
        }

        .bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0px;
            /* Adjust the gap between columns as needed */
            align-items: center;
        }

        #username {
            padding: 0 55px 0 68px;
            color: #003984;
            font-weight: 300;
        }

        #verify_code {
            padding: 0 55px 0 68px;
            color: #003984;
            font-weight: 300;
        }

        input[type="password"] {
            color: #003984;
            padding: 0 55px 0 68px;
            font-weight: 300;
        }


        input[type="text"] {
            padding: 0 55px 0 68px;
            color: #003984;
            font-weight: 300;
        }

        #username::placeholder,
        #verify_code::placeholder,
        #code::placeholder,
        #password::placeholder,
        #email::placeholder,
        #newpass::placeholder,
        #verifypass::placeholder {
            color: #003984;
            font-size: 21px;
            font-weight: 300;
            font-family: "Public Sans", sans-serif;
        }

        input[type="text"],
        input[type="password"] {
            border: 1px solid #bbb;
            font-size: 21px;
            font-family: "Public Sans", sans-serif;
            /* Main font */
            height: 50px;
            letter-spacing: 1px;
            width: 100%;
            background-color: #c8d4fc;
            border-radius: 0;

            &:focus {
                border: 1px solid #3498db;
            }
        }

        #container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0px;
            /* Adjust the gap between columns as needed */
            align-items: center;
            /* Vertically align items in the center */
        }

        #container h5 {
            margin: 0;
            font-size: 14px;
        }


        a {
            text-align: center;
            font-size: 13px;
            font-weight: 500;
            color: #3498db;

            p {
                padding-bottom: 10px;
            }


        }

        #toggler {
            position: absolute;
            right: 10%;
            top: 58.7%;
            font-size: 20px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #254263;
        }

        #account {
            position: absolute;
            left: 7.5%;
            top: 46.9%;
            font-size: 28px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #e4e4e4;
            border-color: #052d5a;
            border-right: solid 2px #4c86c9;
            padding-right: 6px;
            padding-left: 6px;
            height: 48px;
            display: flex;
            justify-content: left;
            align-items: left;
            font-size: 35px;
        }

        #lock {
            position: absolute;
            left: 7.5%;
            top: 58.5%;
            font-size: 28px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #e4e4e4;
            border-color: #052d5a;
            border-right: solid 2px #4c86c9;
            padding-right: 6px;
            padding-left: 6px;
            height: 48px;
            display: flex;
            justify-content: left;
            align-items: left;
            font-size: 35px;
        }

        #email {
            position: absolute;
            left: 5.5%;
            top: 47%;
            font-size: 28px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #e4e4e4;
            border-color: #052d5a;
            border-right: solid 2px #3d6797;
            padding-right: 6px;
            padding-left: 6px;
            height: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 35px;
        }


        .password-container #toggler2 {
            position: absolute;
            right: 7.9%;
            top: 58.4%;
            font-size: 20px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #254263;
        }

        .password-container #toggler1 {
            position: absolute;
            right: 7.8%;
            top: 47.4%;
            font-size: 20px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #254263;
        }

        button {
            background: #003984;
            border: none;
            border-radius: 50px;
            color: #fff;
            font-size: 19px;
            font-weight: 300;
            /* cursor: pointer; */
            transition: box-shadow .4s ease;
            box-shadow: 1px 3px 8px #222;
            text-transform: uppercase;
            width: 100%;
            height: 50px;
            margin-top: 5%;
            /* margin-left: 0%; */
            display: flex;
            justify-content: center;
            align-items: center;

            letter-spacing: 1px;

            &:hover {
                box-shadow: 1px 1px 7px rgb(1, 85, 1);
            }

            &:active {
                box-shadow: 1px 2px 7px #222;
            }
        }

    }


}