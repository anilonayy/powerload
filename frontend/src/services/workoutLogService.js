import {computed} from 'vue';
import axios from '@/plugins/appAxios';
import store from '@/store';


const getAllLogs = async (searchParams = new URLSearchParams()) =>  await axios.get(`/v1/workout-logs${ searchParams.size ? `?${ searchParams.toString() }` : '' }`);

const getLog = async (id) => await axios.get(`/v1/workout-logs/${ id }`);

const getLastLog = async () => {
    const nextRequestDate = computed(() => store.getters['_getNextLastLogRequestTime']);
    const nextTime = new Date(nextRequestDate.value).getTime();
    const currentTime = new Date().getTime();

    if(nextTime < currentTime) {
        const response = await axios.get('/v1/workout-logs/last');

        await store.dispatch('setWorkoutLogId', response?.data?.id);
        response.data?.workout_id && await store.dispatch('selectWorkout', response.data.workout_id);
        response.data?.workout_day_id && await store.dispatch('selectWorkoutDay', response.data.workout_day_id);
    
        await store.dispatch('setNextLastLogRequestTime', new Date().setMinutes(new Date().getMinutes() + 5));
    }
}

const getForceLastLog = async () => {
    const response = await axios.get('/v1/workout-logs/last');

    await store.dispatch('setWorkoutLogId', response?.data?.id);
    response.data?.workout_id && await store.dispatch('selectWorkout', response.data.workout_id);
    response.data?.workout_day_id && await store.dispatch('selectWorkoutDay', response.data.workout_day_id);

    return response;
}

const createEmptyLog = async () => {
    const response = await axios.post('/v1/workout-logs/last-or-new');

    await store.dispatch('setWorkoutLogId', response.data.id);

    return response;
}

const updateWorkoutLog = async (id, data) => await axios.put(`/v1/workout-logs/${ id }`, data);

const selectWorkout = async (logId, workout_id) => {
    await updateWorkoutLog(logId, {
        workout_id
    });

    await store.dispatch('selectWorkout', workout_id);
}

const selectWorkoutDay  = async(id, workout_day_id) => {
    const response = await updateWorkoutLog(id, {
        workout_day_id,
        is_new: true
    });

    await store.dispatch('selectWorkoutDay', workout_day_id);
    await store.dispatch('setExercisesOfDay', response?.data?.exercises);
}

const saveExercise = async (id, currentExercise) => {
    const addSetsResponse = await axios.post(`/v1/workout-logs/${ id }/exercises`, {
        sets: currentExercise.onWorkout,
        exercise: currentExercise,
    });

    store.dispatch('setOnWorkoutData', {
        exercise_id: currentExercise.id,
        value: addSetsResponse.data.map((exercise_log) => {
            return {
                id: exercise_log.id,
                reps: exercise_log.reps,
                weight: exercise_log.weight,
                repsError: false,
                weightError: false,
                createTime: new Date().getTime(),
            }
        })
    });
}

const completeWorkout = async (id) => {
    await axios.patch(`/v1/workout-logs/${ id }/complete`);
    
    await store.dispatch('setWorkouts', []);
}

const giveUp = async (id) => {
    await axios.post(`v1/workout-logs/${ id }/give-up`);

    await store.dispatch('setWorkouts', []);
}

const getWorkoutResult = async (id) => await axios.get(`/v1/workout-logs/${ id }/daily-results`);


export default {
    getAllLogs,
    getLog,
    getLastLog,
    createEmptyLog,
    updateWorkoutLog,
    selectWorkout,
    selectWorkoutDay,
    saveExercise,
    completeWorkout,
    giveUp,
    getWorkoutResult,
    getForceLastLog
}