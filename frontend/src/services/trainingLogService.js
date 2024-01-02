import axios from '@/utils/appAxios';
import store from '@/store';


const getAllLogs = async () =>  await axios.get('/v1/training-logs');

const getLog = async (id) => await axios.get(`/v1/training-logs/${ id }`);

const getLastLog = async () => await axios.get('/v1/training-logs/last');

const createEmptyLog = async () => {
    const response = await axios.post('/v1/training-logs');

    await store.dispatch('setTrainingLogId', response.data.id);

    return response;
}

const updateTrainingLog = async (id, data) => await axios.put(`/v1/training-logs/${ id }`, data);

const selectTraining = async (logId, training_id) => {
    await updateTrainingLog(logId, {
        training_id
    });

    await store.dispatch('selectTraining', training_id);
}

const selectTrainingDay  = async(id, training_day_id) => {
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