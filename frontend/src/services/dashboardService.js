import axios from '@/utils/appAxios';

const getStats = async () => {
    const response = await axios.get('v1/training-logs/dashboard-stats');

    return response;
};

export default {
    getStats
}