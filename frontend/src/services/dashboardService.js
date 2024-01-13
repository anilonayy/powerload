import axios from '@/utils/appAxios';

const getStats = async () => {
    const response = await axios.get('v1/training-logs/dashboard-stats');

    return response;
};

const getPersonalRecords = async () => {
    const response = await axios.get('v1/training-logs/personal-records');

    return response;
}

const getExerciseHistory = async (config = {}) => {
    const response = await axios.post('v1/training-logs/exercise-history', config);

    return response;
}

export default {
    getStats,
    getPersonalRecords,
    getExerciseHistory
}