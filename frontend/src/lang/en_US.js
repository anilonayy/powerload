export default {
    HOME: {
        HEADER: {
            TOP_TITLE: 'WHAT IS POWERLOAD?',
            TITLE: 'Progressive Overload <br> grow with your weights',
            DESCRIPTION_TEXT_1: 'Progressive Overload is a method that provides benefits in <b>strength and muscle</b> gain by continuously increasing <b>weight/reps</b> over a period of time.',
            DESCRIPTION_TEXT_2: 'With this app you can easily track your workout and <b>weights</b>!'
        }, 
        STEPS: {
            1: {
                TITLE: 'Register',
                DESCRIPTION: 'You can start using this application by register for free.'
            },
            2: {
                TITLE: 'Do Workout',
                DESCRIPTION: 'You can only get the best results with regular workout!'
            },
            3: {
                TITLE: 'Save your exercises',
                DESCRIPTION: 'Write down the weights and repetitions of the movements you want to get stronger in your workout.'
            },
            4: {
                TITLE: 'Analyse it!',
                DESCRIPTION: 'Analyze your progress by tracking the increases of the weights you lifted in the past!'
            },
        },
        DOWNLOAD_TEXT : 'Download the app and track your workouts!',
    },
    SIDEBAR: {
        MENU: {
            HOME: 'Home',
            ABOUT: 'About',
            DASHBOARD: 'Dashboard',
            WORKOUT_LIST: 'Workout List',
            WORKOUT_HISTORY: 'Workout History',
            RESET_PASSWORD: 'Reset Password',
            PROFILE_SETTINGS: 'Profile Settings',
        },
        AUTH: {
            FOR_MORE_INFO: 'For more information',
            GO_LOGIN: 'login.',
            MY_ACCOUNT: 'Account',
            LOGOUT: 'Logout',
            LOGIN: 'Login',
            OR: 'or',
            REGISTER: 'Register',
        }
    },
    DASHBOARD: {
        TITLE: 'Dashboard',
        TOP_STATS: {
            WORKOUT: 'Workouts',
            AVG_TIME: 'Average Time',
            AVG_EXERCISE: 'Average Exercise',
            X: '?',
            SUBTITLE : '*This informations only calculated by <b>completed</b> workouts.'
        },
        CHART: {
            TITLE: 'Chart by exercise weight',
            FREQUENCY: 'Chart Range',
            EXERCISE: 'Exercise',
            NO_DATA_MESSAGE : 'There is no data for this exercise.',
            FREQUENCY_OPTIONS: {
                YEARLY: {
                    TEXT: 'Yearly',
                    VALUE: 1
                },
                MONTHLY: {
                    TEXT: 'Monthly',
                    VALUE: 2
                },
                WEEKLY: {
                    TEXT: 'Weekly',
                    VALUE: 3
                }
            }
        },
        LAST_WORKOUTS: {
            TITLE: 'Last 5 workouts',
            SEE_ALL: 'see all',
            TIME: 'duration',
            STATUS: {
                CONTINUE: 'Continue',
                COMPLETED: 'Completed',
                CANCELED: 'Canceled'
            }
        },
        PERSONAL_RECORDS: {
            TITLE: 'Personal Records (PR)',
            TABLE: {
                EXERCISE: 'Exercise Name',
                CATEGORY: 'Exercise Category',
                WEIGHT: 'PR (KG)',
                DATE: 'Date',
                SEE: 'See',
            },
            NO_PR: 'You do not have a personal record because you have not trained yet.'
        }
    },
    WORKOUTS: {
        LIST: {
            TITLE: 'Workouts',
            DESCRIPTION: 'Your workouts are listed here and you can add new workouts, workout days and exercises.',
            ADD_BUTTON: 'Add Workout',
            EDIT_BUTTON: 'Edit',
            DELETE_BUTTON: 'Delete',
            TABLE: {
                WORKOUT_NAME:  'Workout Name',
                APPLIED_DAY: 'Applied Day',
                CREATED_AT: 'Created Date',
                ACTIONS:  'Actions',
            },
            NO_DATA: 'You haven\'t added workouts yet! You can add workouts and start powering up!',
            DELETE_ACTION: {
                TITLE: 'Are you sure?',
                TEXT: 'Are you sure you want to delete this workout? This action cannot be undone!',
                CONFIRM_BUTTON: 'Yes, delete it!',
                CANCEL_BUTTON: 'No, cancel!',
                SUCCESS: 'The workout was successfully deleted!',
            }
        },
        ADD: {
            BACK_WORKOUTS: 'Back to workouts',
            TITLE: 'Add Workout',
            DESCRIPTION: 'You can add days to your workout, name them, and access them during workout by clicking on them directly!',
        },
        EDIT: {
            BACK_WORKOUTS: 'Back to workouts',
            TITLE: 'Edit Workout',
            DESCRIPTION: 'You can add days to your workout, name them, and access them during workout by clicking on them directly!',
        },
        WORKOUT_BUILDER: {
            WORKOUT_NAME: 'Workout Name',
            WORKOUT_NAME_PLACEHOLDER: 'Enter Workout Name',
            DAY: 'Day',
            DAY_PLACEHOLDER: 'Enter Day Name',
            DAY_EMPTY_ERROR: 'Day Name Can Not Be Empty!',
            NO_WORKOUT_DAY_ERROR: 'You cannot add an exercise without a workout day!',
            MULTIPLE_SELECT_EXERCISE: 'Each exercise can be selected once within a day!',
            SELECT_EXERCISE: 'Select Exercise',
            EXERCISE: 'Exercise',
            SET: 'Set',
            REP: 'Reps',
            ADD_EXERCISE: 'Add Exercise',
            ADD_DAY: 'Add Workout Day',
            VALIDATION_ERROR: 'Please correct any incorrect or missing fields!',
            SUBMIT_FORM: 'SUBMIT WORKOUT',
        }
    },
    WORKOUT_HISTORY : {
        LIST: {
            TITLE: 'Workout History',
            DESCRIPTION: 'Workout history listing here 👀',
            TABLE: {
                NAME:  'Workout',
                DURATION: 'Workout Duration',
                DATE: 'Workout Date',
                SEE:  'Review',
            },
            SEE_BUTTON: 'Review',
            NO_DATA: 'You haven\'t trained yet! You can start workout and building your strength!',
        },
        SHOW: {
            BACK_TO_LIST: 'Back to list',
            TITLE: 'Workout Details',
            DESCRIPTION: 'Details of your workout are listed here.',
        }
    },
    WORKOUT_RESULT: {
        WORKOUT: 'Workout',
        DURATION: 'Duration',
        EXERCISES: 'Exercises',
        SET: 'Set',
        KG: 'KG'
    },
    RESET_PASSWORD: {
        TITLE: 'Reset Password',
        DESCRIPTION: 'When creating a password, you should make sure that it consists of at least 6 characters, uppercase and lowercase letters. Not mandatory, just a recommendation 🙃',
        FORM: {
            CURRENT_PASSWORD: {
                LABEL: 'Current Password',
                PLACEHOLDER: 'Enter Current Password',
                EMPTY_ERROR: 'Current Password cannot be empty!',
            },
            NEW_PASSWORD: {
                LABEL: 'New Password',
                PLACEHOLDER: 'Enter New Password',
                EMPTY_ERROR: 'New Password cannot be empty!',
            },
            NEW_PASSWORD_CONFIRMATION: {
                LABEL: 'New Password Confirmation',
                PLACEHOLDER: 'Enter New Password Confirmation',
                EMPTY_ERROR: 'New Password Confirmation cannot be empty!',
                MATCH_ERROR: 'Passwords do not match!',
            },
            SUBMIT_BUTTON: 'Update Password',
            SUCCESS_MESSAGE: 'Password was successfully updated',
        }
    },
    PROFILE_SETTINGS: {
        TITLE: 'Profile Settings',
        DESCRIPTION: 'Your name so we can address you, your e-mail address so we can contact you, and that\'s it.',
        FORM: {
            NAME: {
                LABEL: 'Name',
                PLACEHOLDER: 'Enter Name',
                EMPTY_ERROR: 'Name field cannot be empty',
                CHAR_LIMIT_ERROR : 'Name can be at least 2 and up to 50 characters',
            },
            EMAIL: {
                LABEL: 'E-Mail',
                PLACEHOLDER: 'Enter Your E-Mail Address',
                EMPTY_ERROR: 'E-Mail Address cannot be empty!',
                INVALID_ERROR: 'Invalid E-Mail Address!',
            },
            SUBMIT_BUTTON: 'Update Profile',
            SUCCESS_MESSAGE: 'Profile updated was successfully!',
        }
    },
    AUTH: {
        LOGIN: {
            TITLE: 'Login',
            FORM:  {
                EMAIL: 'Email',
                EMAIL_EMPTY_ERROR: 'Email field can not be empty!',
                PASSWORD: 'Password',
                PASSWORD_EMPTY_ERROR: 'Password can not be empty',
                FORGET_PASSWORD: 'Forget Password',
                SUBMIT: 'Login',
                GOOGLE_LOGIN: 'Login with Google',
                NO_ACCOUNT: 'No account?',
                REGISTER: 'Register',
            }
        },
        REGISTER: {
            TITLE: 'Register',
            FORM: {
                NAME: 'Name',
                NAME_EMPTY_ERROR: 'Name field can not be empty!', 
                EMAIL: 'Email',
                EMAIL_EMPTY_ERROR: 'Email field can not be empty!',
                PASSWORD: 'Password',
                PASSWORD_EMPTY_ERROR: 'Password field can not be empty!',
                PASSWORD_CONFIRMATION: 'Password Confirmation',
                PASSWORD_CONFIRMATION_EMPTY_ERROR: 'Password Confirmation field can not be empty!',
                PASSWORD_CONFIRMATION_MATCH_ERROR: 'Passwords Not Matching!',
                SUBMIT: 'Register',
                REGISTER_GOOGLE: 'Register with Google',
                ALREADY_REGISTERED: 'Already Registered?',
                LOGIN: 'Login',
                SUCCESS: 'You have successfully registered!'
            }
        },
        FORGOT_PASSWORD: {
            TITLE: 'Forgot Password',
            DESCRIPTION: 'Please enter the email address of the account you are trying to log in to. A password reset link will be sent to your e-mail address.',
            FORM_SUBMIT: 'Send Mail',
            SUCCESS_MESSAGE: 'We have sended your email the password reset link! Don\'t forget to check your mailbox',
        },
        RESET_PASSWORD: {
            TITLE: 'Reset Password',
            DESCRIPTION: 'It looks like you received the message we sent to your email address 🎉 Now you can create your new password.',
            FORM_SUBMIT: 'Reset Password',
            ERRORS: {
                PASSWORD_EMPTY_ERROR: 'Password can not be empty!',
                PASSWORD_CONFIRMATION_EMPTY_ERROR: 'Password Confirmation can not be empty!',
                PASSWORD_CONFIRMATION_MATCH_ERROR: 'Passwords Not Matching!',
            }
        }
    },
    BOTTOM_BAR: {
        START_WORKOUT: 'Start Workout!',
        CONTINUE_WORKOUT: 'Continue Workout',
    },
    ERRORS: {
        UNKNOWN: 'An error ocurred!',
    },
    FIELDS: {
        NAME: 'Name',
        EMAIL: 'Email',
        PASSWORD: 'Password',
        PASSWORD_CONFIRM: 'Password  confirmation',
    },
    ON_WORKOUT: {
        WHICH_TITLES: {
            WORKOUT: 'Which workout do you want to do?',
            DAY: 'Which workout day do you want to do?',
        },
        COMPLETE_WORKOUT: 'Complete Workout',
        NEXT_EXERCISE: 'Next Exercise',
        GIVE_UP: 'Give Up',
        COMPLETE_WORKOUT_CONFIRM: {
            TITLE: 'Complete Workout',
            TEXT: 'You are about to complete the workout! If you complete it, you can\'t edit it again. Are you sure you entered all the sets correctly?',
            CONFIRM_BUTTON: 'Yes, Complete!',
            CANCEL_BUTTON: 'No, cancel it!',
        },
        SELECT_ANOTHER_DAY_CONFIRM: {
            TITLE: 'Are you sure?',
            TEXT: 'If you choose a different day, your progress on that day will be deleted.',
            CONFIRM_BUTTON: 'Yes, choose new day!',
            CANCEL_BUTTON: 'No, cancel it!'
        },
        PASS_EXERCISE_CONFIRM: {
            TITLE: 'Are you sure?',
            TEXT: 'If you skip the movement, the statistics are not kept.',
            CONFIRM_BUTTON: 'Yes, pass it!',
            CANCEL_BUTTON: 'No, cancel it!'
        },
        GIVE_UP_WORKOUT_CONFIRM: {
            TITLE: 'Are you sure?',
            TEXT: 'If you stop workout, your progress will be erased.',
            CONFIRM_BUTTON: 'Yes, give up!',
            CANCEL_BUTTON: 'No, continue!'
        },
        SELECT_WORKOUT: {
            NO_WORKOUT: 'You haven\'t created a workout yet.',
            LETS_CREATE: 'Let\'s create a workout!',
        },
        EXERCISE: {
            ADD_SET: 'Add Set',
            WEIGHT: 'Weight',
            REP: 'Reps',
            PASSED: 'You skipped this move! Add a new set to avoid skipping.',
        }
    },
    WORKOUT_COMPLETED: {
        CONGURALITATIONS: 'Conguralitations!',
        MOTIVATON_TEXT: 'Today you kept up with your workout and gave it your all! Today you are better than yesterday, tomorrow you will be better than today!',
        LETS_LOOK: 'Let\'s take a quick look at <br /> what we did today! ⬇️ 👀',
    },
    META: {
        HOME: {
            TITLE: 'Powerload - Progressive Overload ile gücüne güç kat!',
        },
        ABOUT: {
            TITLE: 'Hakkımızda - Powerload',
        },
        AUTH: {
            LOGIN: {
                TITLE: 'Giriş Yap - Powerload',
            },
            REGISTER: {
                TITLE: 'Üye Ol - Powerload',
            },
            RESET_PASSWORD: {
                TITLE: 'Şifre Yenile - Powerload',
            }
        },
        GYM_SIDE: {
            DASHBOARD: {
                TITLE: 'Genel Bakış - Powerload',
            },
            WORKOUT_HISTORY: {
                TITLE: 'Antrenman Geçmişi - Powerload',
            },
            SINGLE_WORKOUT_HISTORY: {
                TITLE: 'Antrenman Detayları - Powerload',
            },
            WORKOUT_LIST: {
                TITLE: 'Antrenmanlar - Powerload',
            },
            SINGLE_WORKOUT: {
                TITLE: 'Antrenman - Powerload',
            },
            WORKOUT_ADD: {
                TITLE: 'Antrenman Ekle - Powerload',
            },
            WORKOUT_EDIT: {
                TITLE: 'Antrenman Düzenle - Powerload',
            },
            PROFILE_SETTINGS :{
                TITLE: 'Profil Ayarları - Powerload',
            },
        },
        ON_WORKOUT: {
            TITLE: 'Antrenman - Powerload',
        },
        WORKOUT_COMPLETED: {
            TITLE: 'Antrenman Tamamlandı - Powerload',
        }
    },
}