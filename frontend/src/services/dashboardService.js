import axios from '@/plugins/appAxios';

const getStats = async () => {
    const response = await axios.get('v1/workout-logs/dashboard-stats');

    return response;
};

const getPersonalRecords = async () => {
    const response = await axios.get('v1/workout-logs/personal-records');

    return response;
}

const getExerciseHistory = async (config = {}) => {
    const response = await axios.post('v1/workout-logs/exercise-history', config);

    return response;
}

export default {
    getStats,
    getPersonalRecords,
    getExerciseHistory
}