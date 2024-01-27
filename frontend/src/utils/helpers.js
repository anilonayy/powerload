import DateFrequencyEnums from "@/enums/DateFrequencyEnums";


export const setCookie = (name, value, days) => {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
  }

export const getCookie =  (name) => {
    var nameEQ = name + "=";
    var cookies = document.cookie.split(';');
    for(var i = 0; i < cookies.length; i++) {
      var cookie = cookies[i];
      while (cookie.charAt(0) == ' ') {
        cookie = cookie.substring(1, cookie.length);
      }
      if (cookie.indexOf(nameEQ) == 0) {
        return cookie.substring(nameEQ.length, cookie.length);
      }
    }
    return null;
  }

export const removeCookie = (name) => {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}


export const validateEmail = (email) => {
  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

export const guid = () => {
  let s4 = () => {
      return Math.floor((new Date().getTime() + 1 + Math.random()) * 0x10000)
          .toString(16)
          .substring(1);
  }
  //return id of format 'aaaaaaaa'-'aaaa'-'aaaa'-'aaaa'-'aaaaaaaaaaaa'
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
}

export const  getIconName = (categoryName = '') => {
  let path = '/images/body/';

  if(categoryName === 'Göğüs') {
    path += 'chest.png';
  } else if(categoryName === 'Sırt') {
    path += 'back.png'
  } else if ( categoryName === 'Bacak') {
    path += 'leg.png';
  } else if( categoryName === 'Ön Kol' ) {
    path += 'arm.png'
  } else if (categoryName.includes('Omuz')) {
    path += 'shoulder.png'
  }

  return path;
}

export const validateWorkoutBuilderData = (train) => {


  const response = {
    success: true,
    errorMessage: '',
    data: {}
  };

  if(typeof train.days === 'undefined' || !train.days.length) {
    response.success = false;
    response.errorMessage = 'WORKOUTS.WORKOUT_BUILDER.NO_WORKOUT_DAY_ERROR';
  }

  train.hasError = Boolean(!train.name);
  
  train.days.map((day) => {
    const exerciseIds = [];
    let hasError = false;

    day.hasError = Boolean(!day.name);

    if(day.name.trim().length === 0) {
      day.errorMessage = 'WORKOUTS.WORKOUT_BUILDER.DAY_EMPTY_ERROR';
      day.hasError = true;
      response.success = false;
    } else {
      day.errorMessage = ''
      day.hasError = false;
      response.success = true;
    }

    if(!day.hasError) {
      day.exercises.map((exercise) => {
        if(!hasError && (exercise.selected?.value || 0) !== 0) {
          if(exerciseIds.includes(exercise.selected.value)) {
            response.success = false;
            day.errorMessage = 'WORKOUTS.WORKOUT_BUILDER.MULTIPLE_SELECT_EXERCISE';
            hasError = true;
          } else {
            hasError = false;
            day.errorMessage = '';
            exerciseIds.push(exercise.selected.value);
          }
        } else {
          response.success = false;
        }
  
        exercise.hasError = Boolean(!exercise.selected.value)
      })
    }    
  })

  response.data = train;

  return response;
}

export const getLocale = () =>  getCookie('locale') || 'tr_TR';

export const debounce = (func, delay) => {
    let timer;

    return function (...args) {
      clearTimeout(timer);

      timer = setTimeout(() => {
          func(...args);
      }, delay);
    }
}