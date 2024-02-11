export const shortDateForHumans = (carbonDiff) => {
    const { y,m,d,h,i,s } = carbonDiff;
    let resultDate = '';

    if(y) {
        resultDate = `${y}y `;
    } else if (m) {
        resultDate = `${m}m `;
    } else if (d) {
        resultDate = `${d}d `;
    } else if (h) {
        resultDate = `${h}h `;
    } else if (i) {
        resultDate = `${i}m `;
    } else if (s) {
        resultDate = `${s}s `;
    }


    return resultDate;
}