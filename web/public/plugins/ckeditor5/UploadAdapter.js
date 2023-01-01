class UploadAdapter {
    constructor( loader ) {
        this.loader = loader;
        this.url = '/editor-upload';
        this.meta = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
    }

    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        xhr.open('POST', this.url ,true);
        xhr.responseType = 'json';
        xhr.setRequestHeader('X-CSRF-TOKEN', this.meta);
        console.log( this.meta );
    }

    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = '파일업로드 실패 - 관리자에게 문의하세요.';
        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }
            resolve( {
                default: response.url
            } );
        } );
    }

    _sendRequest(file) {
        const data = new FormData();
        data.append('upload', file );
        this.xhr.send( data );
    }
}