const authHandlers = require('./handlers/authHandlers');

exports.handler = async (event) => {
    try {
        const path = event.resource; 
        const method = event.httpMethod; 

        let responseMessage;
        let statusCode;

        switch (path) {

            
            case '/login':
                if (method === 'POST') {
                    responseMessage = await authHandlers.handleLogin(event);
                    statusCode = 200;
                } else {
                    responseMessage = 'Method Not Allowed';
                    statusCode = 405;
                }
                break;

            case '/register':
                if (method === 'POST') {
                    responseMessage = await authHandlers.handleRegister(event);
                    statusCode = 200;
                } else {
                    responseMessage = 'Method Not Allowed';
                    statusCode = 405;
                }
                break;
            case '/validateToken':
                if (method === 'POST') {
                    responseMessage = await authHandlers.handleValidateToken(event);
                    statusCode = 200;
                } else {
                    responseMessage = 'Method Not Allowed';
                    statusCode = 405;
                }
                break;        
            
            default:
                responseMessage = 'Not Found';
                statusCode = 404;
                break;
        }

        return {
            statusCode: statusCode,
            body: JSON.stringify(responseMessage),
            headers: {
                'Content-Type': 'application/json',
            },
        };
    } catch (error) {
        return {
            statusCode: 500,
            body: JSON.stringify({ message: error.message }),
            headers: {
                'Content-Type': 'application/json',
            },
        };
    }
};