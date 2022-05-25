FROM openjdk:8-jre-slim

ARG ALLURE_VERSION=2.13.8

RUN apt-get update && apt-get install -y  --no-install-recommends curl
RUN curl -o allure-commandline-${ALLURE_VERSION}.tgz -Ls https://repo.maven.apache.org/maven2/io/qameta/allure/allure-commandline/${ALLURE_VERSION}/allure-commandline-${ALLURE_VERSION}.tgz  \
    && tar -zxvf allure-commandline-${ALLURE_VERSION}.tgz -C /opt/ && ln -s /opt/allure-commandline-${ALLURE_VERSION}/bin/allure /usr/bin/allure  \
    && rm -f allure-commandline-${ALLURE_VERSION}.tgz
RUN apt-get remove -y curl \
    && apt-get -y autoremove && rm -rf /var/lib/apt/lists/*
ENV PATH="$PATH:/opt/allure-${ALLURE_VERSION}/bin"
ENV PORT="4040"
ENV ROOT="/builds/warranty-service/warranty-service-api/" 
ENV RESULTS_DIRECTORY="tests/_output/allure-results" 
ENV REPORT_DIRECTORY="tests/_output/allure-report" 


CMD allure generate --clean $ROOT$RESULTS_DIRECTORY --report-dir $ROOT$REPORT_DIRECTORY \
     && exit 0