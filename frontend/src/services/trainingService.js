import axios from '@/utils/appAxios';

export const getAllTrainings = async () =>  await axios.get('v1/trainings');
export const getTraining = async (id) => await axios.get(`v1/trainings/${id}`);