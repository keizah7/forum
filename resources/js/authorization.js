let user = window.app.user;

module.exports = {
    owns (model, prop = 'user_id') {
        return model[prop] === user.id;
    },

    isAdmin () {
        return ['JohnDoe', 'JaneDoe'].includes(user.name);
    }
};
