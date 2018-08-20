/* credit @Daniel Scocco */

/****************** SERVER CODE ****************/

#include <stdio.h>
#include <netinet/in.h>
#include <string.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include<stdlib.h>
#define _GNU_SOURCE         /* See feature_test_macros(7) */
#include <unistd.h>
#include <sys/syscall.h>
char * readline(FILE *fp, char *buffer)
{
    int ch;
    int i = 0;
    size_t buff_len = 0;

    buffer = malloc(buff_len + 1);
    if (!buffer) return NULL;  // Out of memory

    while ((ch = fgetc(fp)) != '\n' && ch != EOF)
    {
        buff_len++;
        void *tmp = realloc(buffer, buff_len + 1);
        if (tmp == NULL)
        {
            free(buffer);
            return NULL; // Out of memory
        }
        buffer = tmp;

        buffer[i] = (char) ch;
        i++;
    }
    buffer[i] = '\0';

    // Detect end
    if (ch == EOF && (i == 0 || ferror(fp)))
    {
        free(buffer);
        return NULL;
    }
    return buffer;
}
// void lineByline(FILE * file){
// char *s;
// while ((s = readline(file, 0)) != NULL)
// {
//     // puts(s);

//     free(s);
//     // printf("\n");
// }
// }

void toUpper(char *str){
  int i=0;
  while(str[i]!='\0'){
    if(str[i]>='a'&&str[i]<='z'){
      str[i]=str[i]-32;
    }
    i++;
  }
}
int main(){
  int welcomeSocket, newSocket;
  char buffer[1024];
  struct sockaddr_in serverAddr;
  struct sockaddr_storage serverStorage;
  socklen_t addr_size;

  /*---- Create the socket. The three arguments are: ----*/
  /* 1) Internet domain 2) Stream socket 3) Default protocol (TCP in this case) */
  welcomeSocket = socket(PF_INET, SOCK_STREAM, 0);

  /*---- Configure settings of the server address struct ----*/
  /* Address family = Internet */
  serverAddr.sin_family = AF_INET;
  /* Set port number, using htons function to use proper byte order */
  serverAddr.sin_port = htons(5432);
  /* Set IP address to localhost */
  serverAddr.sin_addr.s_addr = inet_addr("127.0.0.1");
  /* Set all bits of the padding field to 0 */
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Bind the address struct to the socket ----*/
  bind(welcomeSocket, (struct sockaddr *) &serverAddr, sizeof(serverAddr));

  /*---- Listen on the socket, with 5 max connection requests queued ----*/
  if(listen(welcomeSocket,5)==0)
    printf("I'm listening\n");
  else
    printf("Error\n");

  /*---- Accept call creates a new socket for the incoming connection ----*/
  addr_size = sizeof serverStorage;
  newSocket = accept(welcomeSocket, (struct sockaddr *) &serverStorage, &addr_size);

  /*---- Send message to the socket of the incoming connection ----*/
  while(1){
    if(recv(newSocket,buffer, 1024, 0)){
      if(strncmp(buffer,"wget",4)==0){
        send(newSocket,"wait reading file....\n",22,0);
        char *fileName="/home/kamlesh/cs252/assign3/simple-client-server-demo/test.txt";
        FILE* file = fopen(fileName, "r");
        char *s;
        while ((s = readline(file, 0)) != NULL)
        {
            // puts(s);
            send(newSocket,s,1024,0);
            free(s);
            // printf("\n");
        }
        send(newSocket,"done..",4,0);
      }
      else if(strncmp(buffer,"chrome",6)==0){
        // send(newSocket,"wait opening file in google chrome..\n",100,0);
        char cmd[]="google-chrome file:///home/kamlesh/cs252/assign3/index.html";
        // system(cmd);
        send(newSocket,cmd,1024,0);
      }
      else{
        printf("Data received from client: %s\n",buffer);
        toUpper(buffer);
        // strcpy(buffer,"Hello World\n");
        send(newSocket,buffer,13,0);
      }
    }
  
 
  }
  

  return 0;
}
