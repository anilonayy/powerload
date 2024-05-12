import { useStore } from 'vuex';
import DateEnums from '@/enums/DateEnums';
import exerciseService from '@/services/exerciseService';

export const updateExercises = async () => {
  const store = useStore();
  const exercise_expire_date = Number(localStorage.getItem('exercise_expire_date')) ?? 0;

  if (exercise_expire_date < new Date().getTime()) {
    exerciseService
      .getAllExercises()
      .then((response) => response.data)
      .then(async (data) => {
        await store.dispatch('setExercises', data);
        setExpireStorage();
      });
  }
};

export const setExpireStorage = () => {
  localStorage.setItem('exercise_expire_date', new Date().getTime() + DateEnums.ONE_DAY_AS_MS);
};
