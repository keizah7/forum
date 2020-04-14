let user = window.app.user;

module.exports = {
    updateReply (reply) {
        return reply.user_id === user.id;
    }
};
