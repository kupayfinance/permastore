import React from 'react';


class Message extends React.Component {
    
    render() {
        
        const message = this.props.message;
        
        if(message.result.transaction_id)
        {
            var url = 'https://explorer.kcc.io/en/tx/' + message.result.transaction_id;

            var blockchainlink = <a target="_blank" rel="noopener noreferrer" href={url}>{message.result.transaction_id}</a>
        }
        else
        {
            blockchainlink = <i className="text-danger">Error Storing on Blockchain</i>
        }
        
        return (
            <>
                <tr>
                    <td style={{wordBreak: "break-all"}}>
                    
                    <p>
                        Transaction ID:<br/>
                        <strong>{message.transaction_id}</strong>
                    </p>
                    <p>
                        Contents:<br/>
                        <strong>{message.contents}</strong>
                    </p>
                    <p>
                        Block Chain Transaction:<br/>
                        
                        
                        {blockchainlink}
                    </p>
                    </td>
                        <td>{message.received_at}</td>
                        <td>{message.status}</td>
                </tr>
            </>
        );
    }
};

export default Message;