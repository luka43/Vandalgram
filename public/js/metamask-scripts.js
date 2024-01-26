window.onload = () => {
    checkMetamask();
    ethereum.on('accountsChanged', walletDisconnected);
 };

document.getElementById("wallet-connect").addEventListener("click", () => {

    if (metamaskConected) {
        navigator.clipboard.writeText(accounts[0]);
    } else {
        connectMetamask();
    }
});

document.getElementById("donate-button").addEventListener("click", () => {
    params = [{
          from: accounts[0],
          to: '0x95686ebdE122E369c12409ECFA94ab08b0610246',
          value: '0xAA87BEE538000',
        }];

    ethereum.request({method: 'eth_sendTransaction', params}).then((result) => {
        console.log(result)
})
        .catch((error) => {
            console.log(error)
        });
});

async function checkMetamask() {
    accounts = await ethereum.request({method: 'eth_accounts'});
    metamaskConected = !!accounts.length;
    if (metamaskConected){
        balance =  await ethereum.request({method: "eth_getBalance", params: [accounts[0], "latest"]});
        balance = parseInt(balance, 16) / (10**18);
        account = accounts[0].substring(0, 6) + ".." + accounts[0].substring(accounts[0].length - 6);
        updateButtonText();
    }
}


async function connectMetamask() {
    try {
        accounts = await ethereum.request({method: "eth_requestAccounts"});
    } catch (error) {
        console.log("Error : ", error);
    }
    metamaskConected = !!accounts.length;
    if (metamaskConected){
        balance_result = await ethereum.request({method: "eth_getBalance", params: [accounts[0], "latest"]});
        let wei = parseInt(balance_result,16);
        balance = wei / (10**18);
        updateButtonText();
    }
}

function updateButtonText() {
    account = accounts[0].substring(0, 6) + ".." + accounts[0].substring(accounts[0].length - 6);
    document.getElementById("wallet-balance").innerHTML = balance.toFixed(5);
    document.getElementById("wallet-balance").style.visibility = "visible";
    document.getElementById("button-text").innerHTML = account;
    document.getElementById("copy-icon").style.display = "block";
    document.getElementById("wallet-connect").title="Copy to clipboard";
}

function walletDisconnected() {
    metamaskConected = false;
    accounts = [];
    document.getElementById("wallet-balance").innerHTML = "";
    document.getElementById("wallet-balance").style.visibility = "hidden";
    document.getElementById("button-text").innerHTML = "Connect Wallet";
    document.getElementById("copy-icon").style.display = "none";
    document.getElementById("wallet-connect").title="Connect MetaMask";

}