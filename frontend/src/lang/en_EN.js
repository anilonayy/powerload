export default {
    HOME: {
        HEADER: {
            TOP_TITLE: 'WHAT IS POWERLOAD?',
            TITLE: 'Progressive Overload <br> grow with your weights',
            DESCRIPTION_TEXT_1: 'Progressive Overload is a method that provides benefits in <b>strength and muscle</b> gain by continuously increasing <b>weight/reps</b> over a period of time.',
            DESCRIPTION_TEXT_2: 'With this app you can easily track your training and <b>weights</b>!'
        }, 
        STEPS: {
            1: {
                TITLE: 'Register',
                DESCRIPTION: 'You can start using this application by register for free.'
            },
            2: {
                TITLE: 'Do Workout',
                DESCRIPTION: 'You can only get the best results with regular training!'
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
            TRAINING_LIST: 'Training List',
            TRAINING_HISTORY: 'Training History',
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
            TRAINING: 'Trainings',
            AVG_TIME: 'Average Time',
            AVG_EXERCISE: 'Average Exercise',
            X: '?',
            SUBTITLE : '*This informations only calculated by <b>completed</b> trainings.'
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
                WEEKLY:{
                    TEXT: 'Weekly',
                    VALUE: 3
                }
            }
        },
        LAST_TRAININGS: {
            TITLE: 'Last 5 trainings',
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
    TRAININGS: {
        LIST: {
            TITLE: 'Trainings',
            DESCRIPTION: 'Your workouts are listed here and you can add new workouts, training days and exercises.',
            ADD_BUTTON: 'Add Training',
            EDIT_BUTTON: 'Edit',
            DELETE_BUTTON: 'Delete',
            TABLE: {
                TRAINING_NAME:  'Training Name',
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
                SUCCESS: 'The training was successfully deleted!',
            }
        },
        ADD: {
            BACK_TRAININGS: 'Back to trainigs',
            TITLE: 'Add Training',
            DESCRIPTION: 'You can add days to your training, name them, and access them during training by clicking on them directly!',
        },
        EDIT: {
            BACK_TRAININGS: 'Back to trainigs',
            TITLE: 'Edit Training',
            DESCRIPTION: 'You can add days to your training, name them, and access them during training by clicking on them directly!',
        },
        TRAIN_BUILDER: {
            TRAINING_NAME: 'Training Name',
            TRAINING_NAME_PLACEHOLDER: 'Enter Training Name',
            DAY: 'Day',
            DAY_PLACEHOLDER: 'Enter Day Name',
            DAY_EMPTY_ERROR: 'Day Name Can Not Be Empty!',
            NO_TRAINING_DAY_ERROR: 'You cannot add an exercise without a training day!',
            MULTIPLE_SELECT_EXERCISE: 'Each exercise can be selected once within a day!',
            SELECT_EXERCISE: 'Select Exercise',
            EXERCISE: 'Exercise',
            SET: 'Set',
            REP: 'Reps',
            ADD_EXERCISE: 'Add Exercise',
            ADD_DAY: 'Add Training Day',
            VALIDATION_ERROR: 'Please correct any incorrect or missing fields!',
            SUBMIT_FORM: 'SUBMIT TRAINING',
        }
    }
}