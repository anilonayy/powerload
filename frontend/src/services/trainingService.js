import axios from '@/utils/appAxios';

const getAllTrainings = async () =>  await axios.get('v1/trainings');

const getAllTrainingsWithDetails = async () =>  await axios.get('v1/trainings/details');

const getTraining = async (id) => await axios.get(`v1/trainings/${id}`);

const createTraining = async (training) => await axios.post('v1/trainings', { train: training });

const updateTraining = async (id, training) => await axios.put(`v1/trainings/${id}`, { train: training });

const deleteTraining = async (id) => await axios.delete(`v1/trainings/${id}`);

export default {
    getAllTrainings,
    getAllTrainingsWithDetails,
    getTraining,
    deleteTraining,
    createTraining,
    updateTraining
}