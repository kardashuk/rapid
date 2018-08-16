const { ApolloServer, gql } = require('apollo-server');
const fs = require('fs');
const orql = require('orql');

const Data =  JSON.parse(fs.readFileSync('config/data.json').toString());
var types = fs.readFileSync('config/types.gql').toString();
const typeDefs = gql(types);

//API
const resolvers = {
    Query: {
        books: (parent, args, context, info) => {
            console.log(args.rql, Data.books);
            console.log(orql(Data.books, args.rql));
            return orql(Data.books, args.rql);
        }
    }
};

//SERVER
const server = new ApolloServer({ typeDefs, resolvers });
server.listen().then(({ url }) => {
    console.log(`🚀  Server ready at ${url}`);
});