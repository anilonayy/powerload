import { computed } from 'vue';
import axios from '@/utils/appAxios';
import store from '@/store';


const getAllLogs = async () =>  await axios.get('/v1/training-logs');

const getLog = async (id) => await axios.get(`/v1/training-logs/${ id }`);

const getLastLog = async () => {
    const nextRequestDate = computed(() => store.getters['_getNextLastLogRequestTime']);
    const nextTime = new Date(nextRequestDate.value).getTime();
    const currentTime = new Date().getTime();

    if(nextTime < currentTime) {
        const response = await axios.get('/v1/training-logs/last');

        await store.dispatch('setTrainingLogId', response?.data?.id);
        response.data?.training_id && await store.dispatch('selectTraining', response.data.training_id);
        response.data?.training_day_id && await store.dispatch('selectTrainingDay', response.data.training_day_id);
    
        await store.dispatch('setNextLastLogRequestTime', new Date().setMinutes(new Date().getMinutes() + 5));
    }
}

const createEmptyLog = async () => {
    const response = await axios.post('/v1/training-logs/last-or-new');

    await store.dispatch('setTrainingLogId', response.data.id);

    return response;
}

const updateTrainingLog = async (id, data) => await axios.put(`/v1/training-logs/${ id }`, data);

const selectTraining = async (logId, training_id) => {
    console.log('logId :>> ', logId);
    await updateTrainingLog(logId, {
        training_id
    });

    await store.dispatch('selectTraining', training_id);
}

const selectTrainingDay  = async(id, training_day_id) => {
    console.log('id :>> ', id);

    const response = await updateTrainingLog(id, {
        training_day_id,
        is_new: true
    });

    await store.dispatch('selectTrainingDay', training_day_id);
    await store.dispatch('setExercisesOfDay', response?.data?.exercises);
}

const saveExercise = async (id, currentExercise) => {
    const addSetsResponse = await axios.post(`/v1/training-logs/${ id }/exercises`, {
        sets: currentExercise.onTrain,
        exercise: currentExercise,
    });

    store.dispatch('setOnTrainData', {
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

const completeTraining = async (id) => {
    await axios.patch(`/v1/training-logs/${ id }/complete`);
    
    await store.dispatch('setTrainings', []);
}

const giveUp = async (id) => {
    await axios.post(`v1/training-logs/${ id }/give-up`);

    await store.dispatch('setTrainings', []);
}

const getTrainingResult = async (id) => await axios.get(`/v1/training-logs/${ id }/daily-results`);


export default {
    getAllLogs,
    getLog,
    getLastLog,
    createEmptyLog,
    updateTrainingLog,
    selectTraining,
    selectTrainingDay,
    saveExercise,
    completeTraining,
    giveUp,
    getTrainingResult
}